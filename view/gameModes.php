<?php 
require_once '../config.php';
require_once LOCATOR . '/dal/class.MySQLConnector.php';

$conn = new MySQLConnector();

$result = $conn->getGameMode();

?>
<div id="mainButtonDiv">
	<h2 id="gameName">Game modes</h2>
	<input type="button" value='<?php echo gettext('Block game');?>' name="startMenu" class="mainButtons gameMode <?php echo $result == 1 ? 'active' : ''?>" id="1"/> 
	<input type="button" value='<?php echo gettext('Placement only');?>'	name="startMenu" class="mainButtons gameMode" id="2" /> 
	<input type="button" value='<?php echo gettext('5 turns mode');?>' name="startMenu" class="mainButtons gameMode" id="3"/> 
	<input type="button" value='<?php echo gettext('Infinite turns mode');?>' name="startMenu" class="mainButtons gameMode" id="4" />
</div>
