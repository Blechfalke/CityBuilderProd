<?php 
require_once '../config.php';
require_once LOCATOR . '/dal/class.MySQLConnector.php';
/**
 * CityManager Group 3
 *
 * The game mode is the page where the user select what kind of game he wanna play
 *
 * */
$conn = new MySQLConnector();

$result = $conn->getGameMode();

?>
<div id="header"><?php echo gettext('Game Modes')?></div>
<div id="mainButtonDiv">
	<input type="button" value='<?php echo gettext('Block game');?>' name="startMenu" class="mainButtons gameMode <?php echo $result == 1 ? 'active' : ''?>" id="1"/> 
	<input type="button" value='<?php echo gettext('Placement only');?>' name="startMenu" class="mainButtons gameMode <?php echo $result == 2 ? 'active' : ''?>" id="2" /> 
	<input type="button" value='<?php echo gettext('5 turns mode');?>' name="startMenu" class="mainButtons gameMode <?php echo $result == 3 ? 'active' : ''?>" id="3"/> 
	<input type="button" value='<?php echo gettext('Infinite turns mode');?>' name="startMenu" class="mainButtons gameMode <?php echo $result == 4 ? 'active' : ''?>" id="4" />
</div>
