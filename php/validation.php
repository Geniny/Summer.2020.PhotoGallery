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

?>