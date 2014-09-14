<?php

function substring($str)
{
	return strlen($str)>205 ? substr($str, 0, 200).' ... ... ' : $str;
}