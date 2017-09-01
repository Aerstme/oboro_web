<?php
if (empty($_POST['DBHOST']) || empty($_POST['DBASE']) || empty($_POST['DBUSER']) || empty($_POST['DBPSWD']))
{
	echo 'missing fields';
	exit();
}

$result = mysqli_connect(  
	$_POST['DBHOST'], 
	$_POST['DBUSER'], 
	$_POST['DBPSWD'],
	$_POST['DBASE']
);
if (mysqli_connect_errno()) {
	printf("[ERROR]: %s\n", mysqli_connect_error());
	exit();
} else {
	echo '[EXITO] The configuration is ok.';
}

?>