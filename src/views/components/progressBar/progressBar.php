<?php

//commentaire
function createProgressBar($id, $size)
{

    if ($size != 's' && $size != 'm') {
        $size = 's';
    }

    $html = <<<HTML
    <div id="progressBar" class="$size" id="$id">
    </div>
HTML;
    echo $html;
}