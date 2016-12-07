<?php

function GET($attribut, $value){
    $_GET[$attribut] = $value;
}

GET('id',$id);