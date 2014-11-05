<?php
require_once '../config.php';
header('Content-type: text/html; charset=UTF-8');
$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : null;
?>
<div id="header" style="padding: 100px 0 50px 0;">Bâtisseur de cité</div>
    <div id='mainButtonDiv'>
    <input type='text' name='Username' id='username' class='loginForm' placeholder='Username' value='maurice'/>
    <input type='password' name='Password' id='password' class='loginForm' placeholder='Password' value='test123'/>
    <select class='locale' name='locale' id='langdropdown'>
		<!--<option value='de_DE.UTF-8'>Deutsch</option>-->
    	<option value='en_GB.UTF-8'>English</option>
    	<option value='fr_CH.UTF-8'>Français</option>
    </select>
    
	<input type='button' value='Login' name='Login' class='mainButtons login'/>
	<a href="javascript:void(0)" class="register">Register</a>
    <?php if ($msg != null)
    	  	echo "<p id='errorMSG'>$msg</p>";?>    
</div>
