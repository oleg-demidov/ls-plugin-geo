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
    
    public function ValidateEntityGeo(Entity $oEntity, Behavior $oBehavior, $aGeo = []) {
                
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
        if(!$oBehavior->getGeoForSave('city')){
            return;
        }
        
        $oTarget = $this->PluginGeo_Geo_GetTargetByFilter([
            'target_type' => $oBehavior->getParam('target_type'),
            'target_id' => $oEntity->getId()
            ]);
        if (!$oTarget) {
            $oTarget = Engine::GetEntity('PluginGeo_Geo_Target');
        }
        
        
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
    
    public function RewriteFilter(array $aFilter, Behavior $behavior, $sEntityFull) {

        $oEntitySample = Engine::GetEntity($sEntityFull);

        if (!isset($aFilter['#join'])) {
            $aFilter['#join'] = array();
        }

        if (!isset($aFilter['#select'])) {
            $aFilter['#select'] = array();
        }

        if (array_key_exists('#geo', $aFilter)) {
            $aGeo = [];
            
            $sJoin = "JOIN " . Config::Get('db.table.geo_geo_target') . " gt ON
					t.`{$oEntitySample->_getPrimaryKey()}` = gt.target_id and
					gt.target_type = '{$behavior->getParam('target_type')}'";
                                        
            if (isset($aFilter['#geo']['country'])) {
                $sJoin .= " and gt.country_id = ?d  ";
                $aGeo[] = $aFilter['#geo']['country'];
            } 
            
            if (isset($aFilter['#geo']['region'])) {
                $sJoin .= " and gt.region_id = ?d  ";
                $aGeo[] = $aFilter['#geo']['region'];
            }
            
            if (isset($aFilter['#geo']['city'])) {
                $sJoin .= " and gt.city_id = ?d ";
                $aGeo[] = $aFilter['#geo']['city'];
            }
                                        
            $aFilter['#join'][$sJoin] = $aGeo;
            
        }
        
        return $aFilter;
    }
    
    public function RewriteGetItemsByFilter(array $aResult, Behavior $behavior, array $aFilter)
    {
        if (!$aResult) {
            return;
        }
        /**
         * Список на входе может быть двух видов:
         * 1 - одномерный массив
         * 2 - двумерный, если применялась группировка (использование '#index-group')
         *
         * Поэтому сначала сформируем линейный список
         */
        if (isset($aFilter['#index-group']) and $aFilter['#index-group']) {
            $aEntitiesWork = array();
            foreach ($aResult as $aItems) {
                foreach ($aItems as $oItem) {
                    $aEntitiesWork[] = $oItem;
                }
            }
        } else {
            $aEntitiesWork = $aResult;
        }

        if (!$aEntitiesWork) {
            return;
        }
        /**
         * Проверяем необходимость цеплять категории
         */
        if (isset($aFilter['#with']['#geo'])) {
            $this->AttachGeoForTargetItems($aEntitiesWork, $behavior->getParam('target_type'));
        }
    }
    
    public function AttachGeoForTargetItems($aEntityItems, $sTargetType)
    {
        if (!is_array($aEntityItems)) {
            $aEntityItems = array($aEntityItems);
        }
        $aEntitiesId = array(0);
        foreach ($aEntityItems as $oEntity) {
            $aEntitiesId[] = $oEntity->getId();
        }
        /**
         * Получаем таргеты для всех объектов
         */
        
        $aTargets = $this->GetTargetItemsByFilter([
            '#with' => ['city', 'region', 'country'],
            'target_id in' => $aEntitiesId,
            'target_type' => $sTargetType,
            '#index-from-primary'
        ]);
        
        
        /**
         * Собираем данные
         */
        foreach ($aEntityItems as $oEntity) {
            if (isset($aTargets[$oEntity->_getPrimaryKeyValue()])) {
                $oEntity->_setData(array('_geo_target' => $aTargets[$oEntity->_getPrimaryKeyValue()]));
            } else {
                $oEntity->_setData(array('_geo_target' => null));
            }
        }
    }
    
    public function GetEntityTarget($oEntity, $sTargetType)
    {
        $target = $oEntity->_getDataOne('_geo_target');
        if (is_null($target)) {
            $this->AttachGeoForTargetItems($oEntity, $sTargetType);

            return $oEntity->_getDataOne('_geo_target');
        }
        return $target;
    }
}
