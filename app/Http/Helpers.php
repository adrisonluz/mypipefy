<?php
function FirstAndLastName($data){
    $d = explode(" ", $data);
    return $d[0]." ".end($d);
}
