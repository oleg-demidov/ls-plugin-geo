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
                
        if(!$aGeo['country'] and !$oBehavior->getParam('require_country')){
            return true;
        }
        
        if(!$oCountry = $this->GetCountryById($aGeo['country'])){
            return $this->Lang_Get('plugin.geo.validate.not_fond_country', ['id' => $aGeo['country']]);
        }
        
        if(!$aGeo['region'] and !$oBehavior->getParam('require_region')){
            return true;
        }
        
        if(!$oRegion = $this->GetRegionByFilter([
                'id' => $aGeo['region'],
                'country_id' => $aGeo['country']
            ]))
        {
            return $this->Lang_Get('plugin.geo.validate.not_fond_region');
        }
        
        if(!$aGeo['city'] and !$oBehavior->getParam('require_city')){
            return true;
        }
        
        if(!$oCity = $this->GetCityByFilter([
                'id' => $aGeo['city'],
                'country_id' => $aGeo['country'],
                'region_id' => $aGeo['region'],
            ]))
        {
            return $this->Lang_Get('plugin.geo.validate.not_fond_region');
        }
        
        return true;
    }
    
    public function SaveGeo(Entity $oEntity, Behavior $oBehavior) 
    {
        $oTarget = Engine::GetEntity('PluginGeo_Geo_Target');
        
        if($oBehavior->getGeoForSave('country')){
            $oTarget->setCountryId($oBehavior->getGeoForSave('country'));
        }
        
        if($oBehavior->getGeoForSave('region')){
            $oTarget->setRegionId($oBehavior->getGeoForSave('region'));
        }
        
        if($oBehavior->getGeoForSave('city')){
            $oTarget->setCityId($oBehavior->getGeoForSave('city'));
        }
        
        $oTarget->setTargetType($oBehavior->getParam('target_type'));
        $oTarget->setTargetId($oEntity->getId());
        
        return $oTarget->Save();
    }
}