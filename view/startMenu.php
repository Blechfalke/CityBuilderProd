<?php
session_start();
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/git/CityBuilderProd/config.php');
require_once LOCATOR . '/model/class.User.php';

if (isset($_SESSION ['GameController']))
	unset($_SESSION ['GameController']);

$user = unserialize($_SESSION ['User']);
?>

<div id='mainButtonDiv'>
	<h2 id='gameName'>City builders</h2>
	<input type='button' value='Launch the game' name='PlacementOfCity' class='mainButtons link' /> 
	<input type='button' value='Rules' name='Rules' class='mainButtons link' /> 
	<?php
	
	if ($user->admin == 1) {
		echo "<input type='button'
			value='Game modes' name='GameModes' id='gameModes'
			class='mainButtons link' />";
	} else {
		echo "<div style='height:50px;margin:20px 0;'></div>";
	}
	?>
	<input type='button' value='Exit game' name='ExitGame' id='ExitGame' class='mainButtons link' />
</div>