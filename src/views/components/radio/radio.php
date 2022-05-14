<?php


//$size doit être 'm' ou 'l' (si aucun, m par defaut)
//$enabled doit être 'enabled' ou 'disabled' (si aucun, enabled par defaut)
function createRadio($id, $name, $label, $value, $size, $enabled, $checked)
{
    if ($size != 'm' && $size != 'l') {
        $size = 'm';
    } 
    if ($enabled != 'enabled' && $enabled != 'disabled') {
        $enabled = 'enabled';
    } 
    if ($checked != 'checked') {
        $checked = '';
    } 

    $id = htmlspecialchars($id);
    $name = htmlspecialchars($name);
    $enabled = htmlspecialchars($enabled);
    $checked = htmlspecialchars($checked);
    $size = htmlspecialchars($size);
    $label = htmlspecialchars($label);
    $value = htmlspecialchars($value);

    $html = <<<HTML
    <div class="divCustomRadio $size">
        <input id="$id" class="customRadio" type="radio" name="$name" value="$value" $enabled $checked>
        <label for="$id" class="labelCustomRadio">$label</label>
    </div>
HTML;
    echo $html;
}
