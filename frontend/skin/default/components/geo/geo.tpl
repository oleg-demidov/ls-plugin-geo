
{foreach $aGeoItems as $item}
    {$items[] = [
        'value' => $item->getId(),
        'text' => $item->getName()
    ]}
{/foreach}

{component 'bs-form' template='select'
    name          = "geo[{$name}]"
    label         = {lang "plugin.geo.field.country.label"}
    items         = $items
    selected      = $selectedItem}