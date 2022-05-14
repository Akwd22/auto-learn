<?php

//$size doit être 'm' ou 'l' (si aucun, m par defaut)
//$enabled doit être 'enabled' ou 'disabled' (si aucun, enabled par defaut)
//$checked doit etre 'checked'  ou 'unchecked (si aucun, unchecked par defaut)
//$checked doit etre ''  ou 'required' 
function createCheckbox($id, $name, $label, $size, $required, $enabled, $checked)
{
    if ($checked != 'unchecked' && $checked != 'checked') {
        $checked = 'unchecked';
    }
    if ($size != 'm' && $size != 'l') {
        $size = 'm';
    }
    if ($enabled != 'enabled' && $enabled != 'disabled') {
        $enabled = 'enabled';
    }
    if ($required != '' && $required != 'required') {
        $required = '';
    }

    $id = htmlspecialchars($id);
    $name = htmlspecialchars($name);
    $required = htmlspecialchars($required);
    $enabled = htmlspecialchars($enabled);
    $checked = htmlspecialchars($checked);
    $size = htmlspecialchars($size);
    $label = htmlspecialchars($label);

    $html = <<<HTML
    <div class="divCustomCheckbox $size">
        <input id="$id" class="customCheckbox" type="checkbox" name="$name" $required $enabled $checked>
        <label for="$id" class="labelCustomCheckbox">$label</label>
    </div>
HTML;
    echo $html;
}
