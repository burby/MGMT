<?php
// 
//  auth.php
//  mgmt cms
//  
//  Created by Dan Burby on 2010-09-10.
//  Copyright 2010 Dan Burby, Burby LLC. All rights reserved.
// 

/**
 * Authenticates a user
 */
function auth($user, $key) {
	global $mgmtd;
	$sql = "SELECT 	`mgmt`.`user_pw`, 
					`mgmt`.`user_id`, 
					`mgmt`.`user_username`, 
					`mgmt`.`user_email` 
			FROM 	`mgmt`.`user` 
			WHERE 	`mgmt`.`user_pw` = '$key' 
			LIMIT 	1;";
	if ( $r = $mgmtd->query($sql) ) {
		if ( $r->num_rows == 1 ) {
			return true;
		}
	}
	return false;
}

/**
 * Makes a secure key from the given password/salt pair.
 */
function make_key($pw, $salt) {
	return sha1(md5(md5($pw).md5($salt)));
}

/**
* Generates a random password drawn from the defined set of characters.
*
* Modified from WordPress
*/
function generate_password( $length = 12, $special_chars = true, $extra_special_chars = false ) {
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ( $special_chars )
		$chars .= '!@#$%^&*()';
	if ( $extra_special_chars )
		$chars .= '-_ []{}<>~`+=,.;:/?|';

	$password = '';
	for ( $i = 0; $i < $length; $i++ ) {
		$password .= substr($chars, random(0, strlen($chars) - 1), 1);
	}

	return $password;
}

 /**
 * Generates a random number
 *
 * Modified from WordPress wp_rand
 */
function random( $min = 0, $max = 0 ) {
	global $rnd_value;

	// Reset $rnd_value after 14 uses
	// 32(md5) + 40(sha1) + 40(sha1) / 8 = 14 random numbers from $rnd_value
	if ( strlen($rnd_value) < 8 ) {
		static $seed = 'jimmy';
		$rnd_value = md5( uniqid(microtime() . mt_rand(), true ) . $seed );
		$rnd_value .= sha1($rnd_value);
		$rnd_value .= sha1($rnd_value . $seed);
		$seed = md5($seed . $rnd_value);
	}

	// Take the first 8 digits for our value
	$value = substr($rnd_value, 0, 8);

	// Strip the first eight, leaving the remainder for the next call to wp_rand().
	$rnd_value = substr($rnd_value, 8);

	$value = abs(hexdec($value));

	// Reduce the value to be within the min - max range
	// 4294967295 = 0xffffffff = max random number
	if ( $max != 0 )
		$value = $min + (($max - $min + 1) * ($value / (4294967295 + 1)));

	return abs(intval($value));
}
?>