<?php
session_start();
 
$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : ''; 
?>
<form>
    <div id='mainButtonDiv'>
    <h2 id='gameName'>City builders</h2>
    <input type='text' name='Username' id='username' class='loginForm' placeholder='Username' value="maurice"/>
    <input type='password' name='Password' id='password' class='loginForm' placeholder='Password' value="test123"/>
    <input type='button' value='Login' name='Login' class='mainButtons login'/>
    <?php     
    	if ($msg != '')
    		echo "<p id='errorMSG'>$msg</p>";
    ?>
    </div>
    
</form> 