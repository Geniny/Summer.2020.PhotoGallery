<?php

function email_validation($email)
{
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function password_validation($password)
{
	if(strlen($password) <= 4)
		return false;
	else
		return true;
}

function repeatedPassword_validation($password, $repeatedPassword)
{
	return $password == $repeatedPassword;
}

function image_name_validation($name)
{
	return strlen($name) <= 3 ? false : true;
}

function image_description_validation($description)
{
	return strlen($description) <= 8 ? false : true;
}

?>