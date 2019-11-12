
{if $oGeoTarget and $oGeoTarget->getCity()}
    {$text = $oGeoTarget->getCity()->getName()}
    {$value = $oGeoTarget->getCity()->getId()}
{/if}

{if $oBehaviorGeo->getParam('label')}
    {$label = {lang name=$oBehaviorGeo->getParam('label')}}
{/if}


{component 'bs-form' template='select'
    name          = "{$oBehaviorGeo->getParam('field')}[city]"
    label         = $label
    placeholder   = $oBehaviorGeo->getParam('placeholder')
    attributes    = [
        'data-city'         => true, 
        "autocomplete"      => "off", 
        'data-default-text' => $text,
        'data-default-value'=> $value
    ]
    require       = $oBehaviorGeo->getParam('require')
    value         = $value}
    
