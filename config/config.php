<?php
/**
 * Таблица БД
 */
$config['$root$']['db']['table']['geo_geo_country'] = '___db.table.prefix___geo_country';
$config['$root$']['db']['table']['geo_geo_region'] = '___db.table.prefix___geo_region';
$config['$root$']['db']['table']['geo_geo_city'] = '___db.table.prefix___geo_city';
$config['$root$']['db']['table']['geo_geo_target'] = '___db.table.prefix___geo_target';

$config['$root$']['router']['page']['geo'] = 'PluginGeo_ActionGeo';

return $config;