<?php

if (!function_exists('userActCode')) {
	function userActCode()
	{
		return strtoupper(sha1(substr(md5(rand(0, strlen('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'))), 9, 17)));
	}
}
