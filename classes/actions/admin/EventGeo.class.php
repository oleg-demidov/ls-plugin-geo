<?php
/**
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
 * @link      http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author    PSNet <light.feel@gmail.com>
 *
 */
/*
 *	Работа с механизмом дополнительных полей, модуль Property
 */

class PluginGeo_ActionAdmin_EventGeo extends Event
{


    public function EventCountries()
    {
        $this->SetTemplateAction('countries');
    }


}