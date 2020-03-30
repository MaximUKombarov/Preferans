<?php
	
	$mysqli = new mysqli(DB_Server,DB_User, DB_Pass, DB_Base);

	if ($mysqli->connect_error) {
		if ($debug)
			die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
		else
			die("Обратитесь в службу поддержки. Error code: " . $mysqli->connect_errno);
	}
?>