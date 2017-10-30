<?php
function FirstAndLastName($data){
    $d = explode(" ", $data);
    return $d[0]." ".end($d);
}

function usernameHighlight($text){
	return preg_replace('/(@.[a-z0-9]+)/s', '<strong class="username-highlight">$1</strong>', $text);
}