<?php

function substring($str, $limit = 400)
{
	$cut = $limit+5;
	return strlen($str)>$cut ? substr($str, 0, $limit).' ... ... ' : $str;
}