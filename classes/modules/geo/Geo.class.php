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
                
        if(!$aGeo['city'] and !$oBehavior->getParam('require')){
            return true;
        }
        
        if(!$oCity = $this->GetCityById($aGeo['city']))
        {
            return $this->Lang_Get('plugin.geo.validate.not_fond_city');
        }
        
        return true;
    }
    
    public function SaveGeo(Entity $oEntity, Behavior $oBehavior) 
    {
        $oTarget = Engine::GetEntity('PluginGeo_Geo_Target');
        
        $oCity = $this->GetCityById($oBehavior->getGeoForSave('city'));
        
        $oTarget->setCountryId($oCity->getCountryId());
        $oTarget->setRegionId($oCity->getRegionId());
        $oTarget->setCityId($oCity->getId());
        
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
