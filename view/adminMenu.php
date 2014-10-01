<?php 

echo "
        <div id='mainButtonDiv'>
        <h2 id='gameName'>City builders</h2>
        <input type='button' value='Launch the game' name='CityManagement' class='mainButtons link'/>
        <input type='button' value='Rules' name='Rules' class='mainButtons link'/>
        <input type='button' value='Game modes' name='GameModes' id='gameModes' class='mainButtons link'/>
        <input type='button' value='Exit game' name='ExitGame' id='ExitGame' class='mainButtons link'/>
        </div>";
?>
<script>
$(document).ready(function(){
	$("#gameModes").click(function(){
		project.createDialog('view/dialog.html', 'Your workers have finished the construction of the palace. It will be your home and the center of your government.', 'caravan', 520, 320);	
		$("#dialog").parent().find(".ui-dialog-titlebar").hide();
		})
})
</script>