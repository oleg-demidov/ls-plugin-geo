<?php

class PluginGeo_ActionGeo extends Action
{
    /**
     * Текущий пользователь
     *
     * @var ModuleUser_EntityUser|null
     */
    protected $oUserCurrent = null;
    
    /**
     * Инициализация
     *
     * @return string
     */
    public function Init()
    {
        
        $this->oUserCurrent = $this->User_GetUserCurrent();
        
        
    }

    /**
     * Регистрация евентов
     */
    protected function RegisterEvent()
    {
        
        $this->AddEventPreg( '/^ajax-load$/', '/^$/', 'EventLoad');
        
        $this->AddEventPreg( '/^autocomplete$/', '/^$/', 'EventAutoComplete');
    }

    public function EventLoad() 
    {
        $this->Viewer_SetResponseAjax('json');
        
        $sType = getRequest('type');
        
        if($sType == 'region'){
            $aResults = $this->PluginGeo_Geo_GetRegionItemsByFilter([
                'country_id' => getRequest('country_id')
            ]);
        }
        
        if($sType == 'city'){
            $aResults = $this->PluginGeo_Geo_GetCityItemsByFilter([
                'region_id' => getRequest('region_id')
            ]);
        }
       
        foreach ($aResults as &$item) {
            $item = [
                'value' => $item->getId(),
                'text' => $item->getName()
            ];
        }
        
        $aResults = array_merge([
            [
                'value' => 0,
                'text' => $this->Lang_Get("plugin.geo.field.{$sType}.chooseItem")
            ]
        ],$aResults);
        
        $this->Viewer_AssignAjax('result', $aResults);
    }
    
    public function EventAutoComplete() {
        $this->Viewer_SetResponseAjax('json');
        
        $aCities = $this->PluginGeo_Geo_GetCityItemsByFilter([
            "#with" => ['region'],
            'country_id' => 149,
            '#where' => [
                't.name_ru LIKE ?' => ['%' .getRequest('q'). '%']
            ],
            '#limit' => [0, 10]
        ]);
        
        $aResults = [];
        foreach ($aCities as $city) {
            $aResults[] = [
                'value' => $city->getId(),
                'text' => $city->getName(),
                'html' => $city->getName() . '<br><small>' .$city->getRegion()->getName(). '</small>'
            ];
        }
        
        $this->Viewer_AssignAjax('result', $aResults);
    }

}