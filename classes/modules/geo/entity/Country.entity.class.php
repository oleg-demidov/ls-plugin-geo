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
 * Сущность дополнительного поля
 *
 * @package application.modules.property
 * @since 2.0
 */
class PluginGeo_ModuleGeo_EntityCountry extends PluginGeo_ModuleGeo_EntityGeo
{

    protected $aRelations = [
        'regions' => [ self::RELATION_TYPE_HAS_MANY, "PluginGeo_ModuleGeo_EntityRegion", 'country_id' ],
        'cities' =>  [ self::RELATION_TYPE_HAS_MANY, "PluginGeo_ModuleGeo_EntityCity", 'country_id' ],
    ];
   
}