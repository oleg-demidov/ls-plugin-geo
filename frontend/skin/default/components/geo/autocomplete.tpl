
{if $oGeoTarget}
    {$value = $oGeoTarget->getCity()->getName()}
{/if}


{component 'bs-form' template='select'
    name          = "{$oBehaviorGeo->getParam('field')}[city]_text"
    label         = {lang "plugin.geo.field.city.label"}
    attributes    = ['data-city' => true, "autocomplete" => "off"]
    require       = $oBehaviorGeo->getParam('require')
    value         = $value}
    
