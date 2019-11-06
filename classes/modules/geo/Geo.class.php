<?php
/*
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Oleg Demidov
 *
 */

/**
 * Модуль управления дополнительными полями
 *
 * @package application.modules.property
 * @since 2.0
 */
class PluginGeo_ModuleGeo extends ModuleORM
{
    public function Init() {
        parent::Init();
    }
    
    public function ValidateEntityGeo(Entity $oEntity, array $aGeo, Behavior $oBehavior) {
                
        if(!$aGeo['country'] and $oBehavior->getParam('require_country')){
            return $this->Lang_Get('validate.empty_error', ['field' => $this->Lang_Get('plugin.geo.field.country.label')]);
        }
        
        if(!$oCountry = $this->GetCountryById($aGeo['country'])  && $oBehavior->getParam('require_country')){
            return $this->Lang_Get('plugin.geo.validate.not_fond_country', ['id' => $aGeo['country']]);
        }
        
        if(!$aGeo['region'] and $oBehavior->getParam('require_region')){
            return $this->Lang_Get('validate.empty_error', ['field' => $this->Lang_Get('plugin.geo.field.region.label')]);
        }
        
        $oRegion = $this->GetRegionByFilter([
            'id' => $aGeo['region'],
            'country_id' => $aGeo['country']
        ]);
                
        if(!$oRegion && $oBehavior->getParam('require_region')){
            return $this->Lang_Get('plugin.geo.validate.not_fond_region');
        }
        
        if(!$aGeo['city'] and $oBehavior->getParam('require_city')){
            return $this->Lang_Get('validate.empty_error', ['field' => $this->Lang_Get('plugin.geo.field.city.label')]);
        }
        
        $oCity = $this->GetCityByFilter([
            'id' => $aGeo['city'],
            'country_id' => $aGeo['country'],
            'region_id' => $aGeo['region'],
        ]);
                
        if(!$oCity  && $oBehavior->getParam('require_city')){
            return $this->Lang_Get('plugin.geo.validate.not_fond_city');
        }
        
        if(!$aGeo['address'] and $oBehavior->getParam('require_address')){
            return $this->Lang_Get('validate.empty_error', ['field' => $this->Lang_Get('plugin.geo.field.address.label')]);
        }
        
        if(!$oCity  && $aGeo['address']){
            return $this->Lang_Get('plugin.geo.validate.empty_city_with_address');
        }
        
        return true;
    }
    
    public function SaveGeo(Entity $oEntity, Behavior $oBehavior) 
    {
        if(!$oTarget = $this->GetTargetByFilter([
            'target_type' => $oBehavior->getParam('target_type'),
            'target_id' => $oEntity->getId()
            ]))
        {
            $oTarget = Engine::GetEntity('PluginGeo_Geo_Target');
        }
        
        
        $oTarget->setCountryId($oBehavior->getGeoForSave('country'));
        $oTarget->setRegionId($oBehavior->getGeoForSave('region'));
        $oTarget->setCityId($oBehavior->getGeoForSave('city'));
        $oTarget->setAddress($oBehavior->getGeoForSave('address'));
        
        $oTarget->setTargetType($oBehavior->getParam('target_type'));
        $oTarget->setTargetId($oEntity->getId());
        
        return $oTarget->Save();
    }
    
    public function ForUrlName($sName) {
        return preg_replace(['\s', '\(', '\)'], ['_', '-', ''], $sName);
    }
    
    public function RemoveGeo(Entity $oEntity, Behavior $oBehavior) {
        if($oTarget = $this->GetTargetByFilter([
            'target_type' => $oBehavior->getParam('target_type'),
            'target_id' => $oEntity->getId()
            ]))
        {
            $oTarget->Delete();
        }
    }
}