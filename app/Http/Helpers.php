<?php
function FirstAndLastName($data){
    $d = explode(" ", $data);
    return $d[0]." ".end($d);
}

function usernameHighlight($text){
	return preg_replace('/(@.[a-z0-9]+ )/s', '<strong class="username-highlight">$1</strong>', $text);
}

function markup($text){
	$text = preg_replace( '/(<.*[^>])(.*)(<\/.*>)/sU', '<pre><code>$1$2$3</code></pre>', $text);
	$text = preg_replace( '/(<.*\/>)/s', '<pre><code>$1</code></pre>', $text);
	$text = htmlspecialchars($text);

	$text = preg_replace('#&lt;(/?(?:pre|code))&gt;#', '<\1>', $text);
	$text = nl2br($text);
	$text = usernameHighlight($text);

	$parsedown = new Parsedown();
	return $parsedown->text($text);
}

function object2array($object){
	return json_decode(json_encode($object), true);
}