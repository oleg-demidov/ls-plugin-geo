
{if $oGeoTarget->getCity()}
    {$text = $oGeoTarget->getCity()->getName()}
    {$value = $oGeoTarget->getCity()->getId()}
{/if}


{component 'bs-form' template='select'
    name          = "{$oBehaviorGeo->getParam('field')}[city]"
    label         = {lang "plugin.geo.field.city.label"}
    attributes    = [
        'data-city'         => true, 
        "autocomplete"      => "off", 
        'data-default-text' => $text,
        'data-default-value'=> $value
    ]
    require       = $oBehaviorGeo->getParam('require')
    value         = $value}
    
