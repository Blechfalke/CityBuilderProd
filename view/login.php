<?php
require_once '../config.php';

$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : ''; 

echo "<form>
    <div id='mainButtonDiv'>
    <h2 id='gameName'>City builders</h2>
    <input type='text' name='Username' id='username' class='loginForm' placeholder='Username' value='maurice'/>
    <input type='password' name='Password' id='password' class='loginForm' placeholder='Password' value='test123'/>
    <select class='locale' name='locale'>
		<option value='de_DE.UTF-8'>Deutsch</option>
    	<option value='fr_CH.UTF-8'>Français</option>
    	<option value='en_GB.UTF-8'>English</option>
    </select>
	<input type='button' value='". gettext('Login') . "' name='Login' class='mainButtons login'/>";
    	if ($msg != '')
    		echo "<p id='errorMSG'>$msg</p>";
    
    echo "</div>
</form> ";