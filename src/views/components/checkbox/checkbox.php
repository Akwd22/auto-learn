<?php


//$size doit être 'm' ou 'l' (si aucun, m par defaut)
//$enabled doit être 'enabled' ou 'disabled' (si aucun, enabled par defaut)
function createCheckbox($id, $name, $label, $size, $enabled)
{
    if ($size != 'm' && $size != 'l') {
        $size = 'm';
    } 
    if ($enabled != 'enabled' && $enabled != 'disabled') {
        $enabled = 'enabled';
    } 

    $html = <<<HTML
    <div class="divCustomCheckbox $size">
        <input id="$id" class="customCheckbox" type="checkbox" name="$name" required $enabled>
        <label for="$id" class="labelCustomCheckbox">$label</label>
    </div>
HTML;
    echo $html;
}


