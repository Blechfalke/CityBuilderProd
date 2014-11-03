<?php require_once '../config.php';

require_once LOCATOR . '/model/class.User.php';

if (isset($_SESSION ['GameController']))
	unset($_SESSION ['GameController']);

if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
	if ($msg == "blocked") {
		echo "<script>project.alert('Game blocked');</script>";
	}
}

$user = unserialize($_SESSION ['User']);
?>
<div id="header"><?php echo gettext('City builders');?></div>
<div id='mainButtonDiv'>
	
	<input type='button' value='<?php echo gettext('Launch the Game');?>' name='placementOfCity' class='mainButtons startGame' /> 
	<input type='button' value='<?php echo gettext('Rules');?>' name='rules' class='mainButtons link' /> 
	<?php
	if ($user->admin == 1) {
		echo "<input type='button'
			value='" . gettext('Game Modes') . "' name='gameModes' id='gameModes'
			class='mainButtons link' />";
	} else {
		echo "<div style='height:50px;margin:20px 0;'></div>";
	}
	?>
	<input type='button' value='<?php echo gettext('Exit Game');?>' name='ExitGame' class='mainButtons logout' />
</div>
