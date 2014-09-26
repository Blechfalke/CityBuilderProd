<?php 
session_start();
include 'common/ConfigOptions.php';
require_once __ROOT__ . 'controller/class.GameController.php';
$gameController = new GameController();

$_SESSION['GameController'] = serialize($gameController);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
  
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>City Builder</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
 <link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.css" />
 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="scripts/scripts.js"> </script>
<script src="scripts/jquery-ui.js"></script>
</head>
<body>
<div id="wrapper">
	
</div>

</body>

</html>
