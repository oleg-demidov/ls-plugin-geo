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
    
    public function ValidateEntityGeo($oEntity, $oBehavior) {
        return true;
    }
}