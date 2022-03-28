<?php
class Button {

    public $size;//s, m, or l (m by default)
    public $outline;//default or outline (default by default)
    public $text;//text
    
    public function __construct($size, $outline, $text)
    {
        $this->setSize($size);
        $this->setOutline($outline);
        $this->setText($text);
    }


    public function getSize(){return $this->size;}

    public function getOutline(){return $this->outline;}

    public function getText(){return $this->text;}

    public function setSize($size){
        if($size=='s' || $size=='m' || $size=='l')
            {$this->size=$size;}
        else
            {$this->size='m';}    
    }

    public function setOutline($outline){
        if($outline=='default' || $outline=='outline')
            {$this->outline=$outline;}
        else
            {$this->outline='default';}
    }

    public function setText($text){
        $this->text=$text;
    }



    public function toHtml(){
        $html = <<<HTML
        <input class="$this->size $this->outline" type="button" value="$this->text">
HTML;
    return $html;
    }

}
?>