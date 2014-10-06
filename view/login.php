<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<?php $message = isset($_GET['msg']) ? urldecode($_GET['msg']) : '';?>
<body>
 	<div id="wrapper">
	 	<form action="controller/class.loginController.php" method="post">
	        <div id="mainButtonDiv">
	        <h2 id="gameName">City builders</h2>
	        <input type="text" name="Username" class=""/>
	        <input type="password" name="Password" class=""/>
	        <input type="submit" value="Login" name="Login" class="mainButtons"/>
	        </div>
	        <p style="color:red;"> <?php echo $message?></p>
        </form>
    </div>
</body>
</html>