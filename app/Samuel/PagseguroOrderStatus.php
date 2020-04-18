<?php
namespace App\Services\Checkout\Payment;

class PagseguroOrderStatus {

    /**
     * Get status string of Pagseguro by status
     *
     * @param integer $status
     * @return string
     */
    public function get(int $status): string {
        if ($status == 1) {
            return "Estamos processando seu pagamento";
        } elseif ($status == 2) {
            return "Em análise";
        } elseif ($status == 3) {
            return "Paga";
        } elseif ($status == 4) {
            return "Paga";
        } elseif ($status == 5) {
            return "Em disputa";
        } elseif ($status == 6) {
            return "Devolvida";
        } elseif ($status == 7) {
            return "Cancelada";
        }

        return "Estamos processando seu pagamento";
    } 

}