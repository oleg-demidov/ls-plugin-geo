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

class PluginGeo_ModuleGeo_EntityTarget extends EntityORM
{
     protected $aRelations = [
        'region'    => [ self::RELATION_TYPE_BELONGS_TO, "PluginGeo_ModuleGeo_EntityRegion", 'region_id' ],
        'country'   => [ self::RELATION_TYPE_BELONGS_TO, "PluginGeo_ModuleGeo_EntityCountry", 'country_id' ],
        'city'      => [ self::RELATION_TYPE_BELONGS_TO, "PluginGeo_ModuleGeo_EntityCity", 'city_id' ],
    ];
      
    
}