<?php
function escape($string){
    return htmlenteties($string, ENT_QUOTES, 'UTF-8');
}

