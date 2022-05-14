<?php

function createMessage()
{   $message='';
    $type='';
    if (isset($_GET["error"])) 
        {$message = $_GET["error"];$type = 'error';}
    if (isset($_GET["success"])) 
        {$message = $_GET["success"];$type = 'success';}

    if (isset($_GET["error"]) || isset($_GET["success"])) {
        $message = htmlspecialchars($message);
        $type = htmlspecialchars($type);

        $html = <<<HTML
        <div class="messageField $type">
            <p class="message">$message</p>
        </div>
HTML;
        echo $html;   
    }
}

