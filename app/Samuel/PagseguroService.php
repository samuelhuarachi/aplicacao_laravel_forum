<?php
namespace App\Samuel;

use Auth;
use PagSeguro;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use App\Services\Checkout\DrinkOrder\DrinkOrder;
use App\Services\Checkout\PizzaOrder\PizzaOrder;
use App\Services\Checkout\Shipping\ShippingService;
use App\Firebase\Firebase;

class PagseguroService {

    protected $endPoint;
    protected $email;
    protected $token;

    public function __construct()
    {
        // $this->endPoint = env('PAGSEGURO_URL_API');
        // $this->email = env('PAGSEGURO_EMAIL');
        // $this->token = env('PAGSEGURO_TOKEN');
    }

    /**
     * Search for notification in pagseguro function
     *
     * @param string $notificationType
     * @param string $notificationCode
     * @return void
     */
    public function receiveNotification(
        string $notificationType, 
        string $notificationCode)
    {
        try {
            $orderDetailsXml = $this->findByNotificationCode($notificationCode);
            
            $reference = $this->getReferece($orderDetailsXml);
            $orderID = (int)str_replace("ORDERID", "", $reference);
            $status = $this->getStatus($orderDetailsXml);
            
            $orderFinded = $this->order::find($orderID);
            $orderFinded->payment_status = $status;
            $orderFinded->save();

            $fb = $this->firebase->getInstance();
            $database = $fb->getDatabase();
            $firebaseGpsReference = env('FIREBASE_SAMUCA_PIZZA', 'pizza-error');
            $reference = $database->getReference($firebaseGpsReference . '/orders/' . $orderFinded->user_id);
            $firebaseKey = $orderFinded->firebase;

            $updates = [
                $firebaseKey => [
                    'payment_status' => $status
                ]
            ];
            
            $reference
               ->update($updates);

            
        } catch(\Exception $e) {
            return \Exception($e->getStatus() . $e->getMessage());
        }
    }

    public function getReferece($pagseguroXML): string {
        return (string)$pagseguroXML->reference[0];
    }

    public function getStatus($pagseguroXML): int {
        return (int)$pagseguroXML->status[0];
    }

    public function findByNotificationCode($notificationCode)
    {

        $url = $this->endPoint 
                . 'transactions/notifications/' . $notificationCode
                . '?email=' . $this->email
                . '&token=' . $this->token;
        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $url);
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            return null;
        }
        
        $body = $res->getBody();
        $xml = simplexml_load_string($body) or die("Error: Cannot create object");
        return $xml;
    }

    public function createNewTransaction($orderID, $data, $email)
    {
        $authEmail = $email;
        //$data['address_zipcode'] = preg_replace('/\D/', '', $data['address_zipcode']);

        // $orderItens = Session::all()['OrderItens'];
        $priceTotal = 0;
        $itemArrayOut = [];
        $shippingCost = 0;

        $itemArray['itemId'] = "50CRE";
        $itemArray['itemDescription'] = "50 de credito";
        $itemArray['itemAmount'] = 50;
        $itemArray['itemQuantity'] = "1";

        $itemArrayOut[] = $itemArray;

        $priceTotal = 50 + $shippingCost;

        $pagseguro = PagSeguro::setReference('ORDERID' . $orderID)
            ->setSenderInfo([
                'senderName' => $data['card_name'], //Deve conter nome e sobrenome
                'senderPhone' => "(19) 97137-1500", //Código de área enviado junto com o telefone
                'senderEmail' => $email,
                'senderHash' => $data['pagseguro-hash'],
                'senderCPF' => "38567749808" //Ou CNPJ se for Pessoa Júridica
            ])
            ->setCreditCardHolder([
                'creditCardHolderName' => $data['card_name'],
                'creditCardHolderCPF' => $data['card_cpf'],
                'creditCardHolderBirthDate' => '10/02/2000'
            ])
            // ->setShippingAddress([
            //     'shippingAddressStreet' => $data['address_street'],
            //     'shippingAddressNumber' => $data['address_number'],
            //     'shippingAddressDistrict' => $data['address_neighborhood'],
            //     'shippingAddressPostalCode' => $data['address_zipcode'],
            //     'shippingAddressCity' => $data['address_city'],
            //     'shippingAddressState' => 'SP'
            // ])
            ->setItems($itemArrayOut)
            //->setExtraAmount(round($shippingCost, 2))
            ->send([
                'paymentMethod' => 'creditCard',
                'creditCardToken' => $data['card_token'],
                'installmentQuantity' => '1',
                'installmentValue' =>  round($priceTotal, 2),
            ]);
    }

    public function newOrder($data, $userData)
    {
        // PAGSEGURO_TOKEN
        // PAGSEGURO_URL_API

        $date = explode("/", $data['card_expire']);

        $card_number = str_replace(' ', '', $data['card_number']);
        

        $data['credits_total'] = 1; // remover essa linha em prod
        $json_creditcard = '{
            "reference_id": "'. $this->generateRandomString() .'",
            "description": "Credito Camstream",
            "amount": {
              "value": '.$data['credits_total'].'00,
              "currency": "BRL"
            },
            "payment_method": {
              "type": "CREDIT_CARD",
              "installments": 1,
              "capture": true,
              "card": {
                "number": "'.$card_number.'",
                "exp_month": "'.$date[0].'",
                "exp_year": "20'.$date[1].'",
                "security_code": "'.$data['card_cvv'].'",
                "holder": {
                  "name": "'.$data['card_name'].'"
                }
              }
            },
            "notification_urls": [
              "'.env('NODEAPI').'/api/client/notification-pagseguro"
            ]
          }';
        
        $url = env("PAGSEGURO_URL_API") . "/charges";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_creditcard);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: ' . env('PAGSEGURO_TOKEN'),
            'x-api-version: 4.0'
        ));
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return ["info" => $info, "response" => $response];
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function registerNewOrderInApi($token, $response)
    {
        $data = ["token" => $token, "transaction" => $response];
        $data_string = json_encode($data);

        $url = env("NODEAPI") . "/api/client/new-transaction";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] !== 200) {
            return null;
        }

        return $response;
    }
}

