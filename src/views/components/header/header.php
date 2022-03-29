<?php
function infoHead ($title, $description, $link_style)
{
    $html = <<<HTML
        <title>$title</title>
        <link rel="shortcut icon" href="../images/logoNoir.png"/>
        <link rel="stylesheet" type="text/css" href="$link_style"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="$description"/>
        <meta name="author" content="DRUET Eddy, GILI Clément, AULOY Rémy, BARBIER Tom, SONVICO Guillaume, MANZANO Lilian" />
HTML;
echo $html;
}

function createLink($title, $className)
{
    $html = <<<HTML
        <a class=$className href="#">
            $title
        </a>
HTML;
echo $html;
}


function createrNavbar()
{
    $html = <<<HTML
    <div>
        <nav>

        </nav>
    </div>

HTML;
echo $html;
}

?>



