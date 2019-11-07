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
 * @author Maxim Mzhelskiy <rus.engine@gmail.com>
 *
 */

/**
 * Обработка блока с редактированием свойств объекта
 *
 * @package application.blocks
 * @since 2.0
 */
class PluginGeo_BlockGeo extends Block
{
    /**
     * Запуск обработки
     */
    public function Exec()
    {
        $sEntity = $this->GetParam('entity');
        $oTarget = $this->GetParam('target');

        if (!$oTarget) {
            $oTarget = Engine::GetEntity($sEntity);
        }

        $aBehaviors = $oTarget->GetBehaviors();
        foreach ($aBehaviors as $oBehavior) { 
            /**
             * Определяем нужное нам поведение
             */
            if ($oBehavior instanceof PluginGeo_ModuleGeo_BehaviorEntity) {
                
                $oGeoTarget = $this->PluginGeo_Geo_GetTargetByFilter([
                    'target_type' => $oBehavior->getParam('target_type'),
                    'target_id' => $oTarget->getId()
                ]);                
                
                $this->Viewer_Assign('oGeoTarget', $oGeoTarget);                 
                        
                $this->Viewer_Assign('oBehaviorGeo', $oBehavior); 
                
//                $this->Viewer_Assign('aCountries', $this->PluginGeo_Geo_GetCountryItemsByFilter([
//                    'id' => 149
//                ]));
                
//                if ($oGeoTarget and $oGeoTarget->getCountry()) 
//                {
//                    $this->Viewer_Assign('aRegions', $this->PluginGeo_Geo_GetRegionItemsByFilter([
//                        'country_id' => 149//$oGeoTarget->getCountry()->getId()
//                    ]));
//                }
                
                $this->SetTemplate('component@geo:geo.autocomplete');

            }
        }

    }
}