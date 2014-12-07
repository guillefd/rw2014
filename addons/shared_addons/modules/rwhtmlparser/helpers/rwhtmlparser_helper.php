<?php

function substring($str, $limit = 400)
{
	$cut = $limit+5;
	return strlen($str)>$cut ? substr($str, 0, $limit).' ... ... ' : $str;
}

function get_domain_from_uri__h($uri='')
{
	$parsed = parse_url($uri);
	return $parsed['host'];
}



