<?php
require_once '../config.php';

/**
 * CityManager Group 3
 *
 * The register page to register as a User
 *
 * */

header('Content-type: text/html; charset=UTF-8');
$msg = isset($_GET['msgRegister']) ? $_GET['msgRegister'] : null;
?>
<div id="header"><?php echo gettext('Registration');?></div>
    <div id='mainButtonDiv'>
    <input type='text' name='Username' id='username' class='loginForm' placeholder='Username' value='<?php echo isset($_GET['username']) ? $_GET['username'] : '';?>'/>
    <input type='password' name='Password' id='password' class='loginForm' placeholder='Password'/>
    <input type='password' name='RePassword' id='repassword' class='loginForm' placeholder='Re-Type Password'/>
	<input type='button' value='Register now' name='Register' class='mainButtons registerNow'/>
	<input type='button' value='Cancel' name='login' class='mainButtons link'/>
    <?php if ($msg != null)
    	  	echo "<p id='errorMSG'>$msg</p>";?>
</div>