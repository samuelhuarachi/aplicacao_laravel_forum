<?php
namespace App\Samuel;

use App\City;
use App\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class General
{
    protected $cityModel;
    protected $stateModel;

    public function __construct(City $city, State $stateModel) {
        $this->cityModel = $city;
        $this->stateModel = $stateModel;
    }

    public function getCitysAvailableFromCache()
    {
    
        return Cache::remember('citys-available', 604800, function () {
            return DB::table('topics')->select('city_id')->distinct()->get();
        });

    }

    public function generateSchemaScanCityState($citysAvailable)
    {
        foreach($citysAvailable as $cityID) {
            $cityFinded = $this->cityModel->find($cityID->city_id);
            $stateFinded = $this->stateModel->find($cityFinded->state_id);
            echo '[<br>'
                        .$stateFinded->id.
                        ','
                        .$stateFinded->slug.
                        ','
                        .$cityFinded->id.
                        ','
                        .$cityFinded->slug.
            '<br>],<br>';
        }
    }

    public function travestiComLocalMap()
    {
        return [
            [
                'url' => 'https://www.travesticomlocal.com.br/porto-velho/',
                'state_id' => 21,
                'city_id' => 17
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/rio-branco/',
                'state_id' => 1,
                'city_id' => 67
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/manaus/',
                'state_id' => 3,
                'city_id' => 112
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/ananindeua/',
                'state_id' => 13,
                'city_id' => 161
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/belem/',
                'state_id' => 14,
                'city_id' => 170
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/macapa/',
                'state_id' => 4,
                'city_id' => 303
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/palmas/',
                'state_id' => 27,
                'city_id' => 443
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/sao-luis/',
                'state_id' => 10,
                'city_id' => 635
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/teresina/',
                'state_id' => 17,
                'city_id' => 881
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/fortaleza/',
                'state_id' => 6,
                'city_id' => 948
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/natal/',
                'state_id' => 20,
                'city_id' => 1162
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/campina-grande/',
                'state_id' => 20,
                'city_id' => 1162
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/joao-pessoa/',
                'state_id' => 15,
                'city_id' => 1336
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/recife/',
                'state_id' => 16,
                'city_id' => 1595
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/maceio/',
                'state_id' => 2,
                'city_id' => 1695
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/aracaju/',
                'state_id' => 25,
                'city_id' => 1753
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/feira-de-santana/',
                'state_id' => 5,
                'city_id' => 1956
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/salvador/',
                'state_id' => 5,
                'city_id' => 2161
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/belo-horizonte/',
                'state_id' => 11,
                'city_id' => 2308
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/divinopolis/',
                'state_id' => 11,
                'city_id' => 2489
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/juiz-de-fora/',
                'state_id' => 11,
                'city_id' => 2662
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/patos-de-minas/',
                'state_id' => 11,
                'city_id' => 2803
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/uberaba/',
                'state_id' => 11,
                'city_id' => 3065
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/uberlandia/',
                'state_id' => 11,
                'city_id' => 3066
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/varginha/',
                'state_id' => 11,
                'city_id' => 3076
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/cachoeiro-de-itapemirim/',
                'state_id' => 8,
                'city_id' => 3111
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/cabo-frio/',
                'state_id' => 19,
                'city_id' => 3185
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/campos-dos-goytacazes/',
                'state_id' => 19,
                'city_id' => 3190
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/rj/',
                'state_id' => 19,
                'city_id' => 3241
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/volta-redonda/',
                'state_id' => 19,
                'city_id' => 3265
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/bauru/',
                'state_id' => 26,
                'city_id' => 3333
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/campinas/',
                'state_id' => 26,
                'city_id' => 3374
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/ribeirao-preto/',
                'state_id' => 26,
                'city_id' => 3753
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/sao-jose-do-rio-preto/',
                'state_id' => 26,
                'city_id' => 3822
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/sao-paulo-sp/',
                'state_id' => 26,
                'city_id' => 3828
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/curitiba/',
                'state_id' => 18,
                'city_id' => 4004
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/foz-do-iguacu/',
                'state_id' => 18,
                'city_id' => 4029
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/londrina/',
                'state_id' => 18,
                'city_id' => 4101
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/maringa/',
                'state_id' => 18,
                'city_id' => 4119
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/ponta-grossa/',
                'state_id' => 18,
                'city_id' => 4185
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/brusque/',
                'state_id' => 24,
                'city_id' => 4357
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/chapeco/',
                'state_id' => 24,
                'city_id' => 4376
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/florianopolis/',
                'state_id' => 24,
                'city_id' => 4397
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/jaragua-do-sul/',
                'state_id' => 24,
                'city_id' => 4443
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/joinville/',
                'state_id' => 24,
                'city_id' => 4446
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/passo-fundo/',
                'state_id' => 23,
                'city_id' => 4907
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/porto-alegre/',
                'state_id' => 23,
                'city_id' => 4927
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/campo-grande/',
                'state_id' => 12,
                'city_id' => 5118
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/dourados/',
                'state_id' => 12,
                'city_id' => 5130
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/goiania/',
                'state_id' => 9,
                'city_id' => 5412
            ],
            [
                'url' => 'https://www.travesticomlocal.com.br/brasilia-df/',
                'state_id' => 7,
                'city_id' => 5564
            ],
        ];
    }
}