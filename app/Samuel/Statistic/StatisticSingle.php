<?php
namespace App\Samuel\Statistic;

use App\City;
use App\State;
use App\LastSee;


class StatisticSingle {

    protected $find;
    protected $currentCityTitle = null;
    protected $trackCity = null;
    protected $cellphone;
    protected $lastSeeModel;
    protected $cityModel;
    protected $stateModel;
    protected $cityID = null;
    
    public function __construct(
                LastSee $lastSeeModel,
                City $cityModel,
                State $stateModel)
    {
        $this->lastSeeModel = $lastSeeModel;
        $this->cityModel = $cityModel;
        $this->stateModel = $stateModel;
    }

    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;
    }
    
    public function get() {
        
        $this->currentCityTitle();
        $this->track();

        return [
            'find' => $this->find,
            'current-city-title' => $this->currentCityTitle,
            'current-city-id' => $this->cityID,
            'track-city' => $this->trackCity
        ];
    }

    public function currentCityTitle()
    {
        $findCurrentCity = $this->lastSeeModel
                                ->where('cellphone', $this->cellphone)
                                ->where('current', true)
                                ->first();
        if (!$findCurrentCity) {
            $this->find = null;
            return;
        }

        $this->find = true;
        $cityFind = $this->cityModel->find($findCurrentCity->city_id);
        $this->currentCityTitle = $cityFind->title;
        $this->cityID = $cityFind->id;
    }

    public function track()
    {
        $tracks = $this->lastSeeModel
                            ->where('cellphone', $this->cellphone)
                            ->orderBy('lastsee', 'asc')
                            ->get();

        $this->trackCity = [];
        foreach($tracks as $lastsee) {
            $cityFind = $this->cityModel->find($lastsee->city_id);

            $this->trackCity[] = [
                'firstsee' => $lastsee->created_at,
                'lastsee' => $lastsee->lastsee,
                'city_title' => $cityFind->title,
                'state_title' => $cityFind->state->title,
                'city_id' => $cityFind->id,
                'state_id' => $cityFind->state->id
            ];
        }
    }
}


