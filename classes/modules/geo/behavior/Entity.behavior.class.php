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
 * Поведение для подключения функционала дополнительных полей к сущностям
 *
 * @package application.modules.property
 * @since 2.0
 */
class PluginGeo_ModuleGeo_BehaviorEntity extends Behavior
{
    /**
     * Дефолтные параметры
     *
     * @var array
     */
    protected $aParams = array(
        'target_type'   => '',
        'field'         => 'geo',
        'require'       => true,
        'label'         => 'plugin.geo.field.city.label',
        'placeholder'   => ''
    );
    
    protected $aGeo;
    
    protected $target;
    /**
     * Список хуков
     *
     * @var array
     */
    protected $aHooks = array(
        'validate_after' => 'CallbackValidateAfter',
        'after_save'     => 'CallbackAfterSave',
        'after_delete'   => 'CallbackAfterDelete',
    );

    /**
     * Коллбэк
     * Выполняется при инициализации сущности
     *
     * @param $aParams
     */
    public function CallbackValidateAfter($aParams)
    {
        if ($aParams['bResult']) {
            $aFields = $aParams['aFields'];
            if (is_null($aFields) or in_array('geo', $aFields)) {
                $oValidator = $this->Validate_CreateValidator('geo_check', $this, $this->getParam('field'));
                $oValidator->validateEntity($this->oObject, $aFields);
                $aParams['bResult'] = !$this->oObject->_hasValidateErrors();
            }
        }
    }

    /**
     * Коллбэк
     * Выполняется после сохранения сущности
     */
    public function CallbackAfterSave()
    {
        $this->PluginGeo_Geo_SaveGeo($this->oObject, $this);
    }

    /**
     * Коллбэк
     * Выполняется после удаления сущности
     */
    public function CallbackAfterDelete()
    {
        $this->PluginGeo_Geo_RemoveGeo($this->oObject, $this);
    }

   
    public function ValidateGeoCheck($aGeo)
    {
        $this->aGeo = $aGeo;
        return $this->PluginGeo_Geo_ValidateEntityGeo($this->oObject, $this, $aGeo);
    }
    
    public function getGeoForSave($sKey = null) {
        if($sKey){
            if (!isset($this->aGeo[$sKey])) {
                return null;
            }
            return $this->aGeo[$sKey];
        }
        return $this->aGeo;
    }

    
    public function get($sKey = null)
    {
        $oTarget = $this->getTarget();
        
        if($sKey and $oTarget){
            return $oTarget->_getDataOne($sKey);
        }
        
        return $oTarget;
    }
    
    public function getTarget() {
        
        return $this->PluginGeo_Geo_GetEntityTarget($this->oObject, $this->getParam('target_type'));
        
    }

}
