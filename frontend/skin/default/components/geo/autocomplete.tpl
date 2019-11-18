
{if $oGeoTarget and $oGeoTarget->getCity()}
    {$geo = $oGeoTarget->getCity()}
{/if}

{if $geo}
    {$text = $geo->getName()}
    {$value = $geo->getId()}
{/if}

{if $oBehaviorGeo->getParam('label')}
    {$label = {lang name=$oBehaviorGeo->getParam('label')}}
{/if}



{component 'bs-form' template='select'
    name          = "{$oBehaviorGeo->getParam('field')}[city]"
    label         = $label
    placeholder   = $oBehaviorGeo->getParam('placeholder')
    attributes    = [
        'data-input'         => true, 
        "autocomplete"      => "off", 
        'data-default-text' => $text,
        'data-default-value'=> $value
    ]
    attributesGroup = [
        'data-city'         => true
    ]
    clear         = true
    require       = $oBehaviorGeo->getParam('require')
    value         = $value}

    
