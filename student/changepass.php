<?php
	session_start();
	
	$getID=$_SESSION['userID'];
	include('includes/conn.php');
	include('logcheck.php');
	$getprofile=mysql_query("SELECT * FROM studenttbl WHERE accountID = '$getID'");
	$rows=mysql_fetch_array($getprofile);
	
	$getacc=mysql_query("SELECT * FROM usertbl WHERE ID= '$getID'");
	$rowaccs=mysql_fetch_array($getacc);
	
	
	if(isset($_POST['cpass']))
	{
        $oldpass = (string)($_POST['opassword'] ?? '');
        $newpass = (string)($_POST['password'] ?? '');
        if ($newpass === '' || $newpass !== ($_POST['password2'] ?? '')) {
            $passError = 'New passwords do not match.';
        } elseif (!hash_equals((string)$rowaccs['password'], $oldpass) && !password_verify($oldpass, (string)$rowaccs['password'])) {
            $passError = 'Current password is incorrect.';
        } else {
            $q = $conn->prepare('UPDATE usertbl SET password=? WHERE ID=?');
            $accountId = (int)$getID;
            $q->bind_param('si', $newpass, $accountId);
            $q->execute();
            header('Location: studentprofile.php?password_updated=1'); exit;
        }

	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>John Paul College</title>


<link href = "style.css" rel = "stylesheet" type = "text/css"/>

</head>

<body>

<div class='header'>
</div>
	
<nav class='container'>
<?php
include('includes/menu.php');
?>
</nav>





<div id="main">
	<div class="shell">
	<center>
	<?php if (!empty($passError)) echo '<p role="alert">'.htmlspecialchars($passError, ENT_QUOTES, 'UTF-8').'</p>'; ?>
<form class='cmxform' method='POST'>
	<fieldset>
			<legend><h4>Account Details</h4></legend>
			  <ol>
			  <li>
			  <table>
			  <tr>
				<td align='right'><label for="name" > Input Old Password: </label></td>
				<td><input type='password' name='opassword'></td>
			  </tr>
			  <tr>
				<td align='right'><label for="name" > Input New Password: </label></td>
				<td><input type='password' name='password'></td>
			  </tr>
			  <tr>
				<td align='right'><label for="name"> Input Password Again: </label></td>
				<td><input type='password' name='password2'></td>
			  </tr>
					</table>
				</li>
				
  </ol>
			
	</fieldset>
	<br>
	
<div align='center'><input type='submit' name='cpass' value='Change Password'>&nbsp;&nbsp;
<input type='reset' name='clear' value='Clear'></div>
</form>
</center>
	</div>
	<div><br></div>
</div>
<!-- /Main -->

<!-- Footer -->
<div id="footer">
	<div class="shell">
		<!-- Mini Nav --> 
		<div class="footer-navigation"> 
		<?php
			include('includes/menu2.php');
		?>
		</div> 
		<!-- /Mini Nav --> 
		
		<!-- Copyrights --> 
		<p class="right"> 
			Copyright 2014 | Online Enrollment
		</p> 
		<!-- /Copyrights --> 
		
		<div class="cl">&nbsp;</div> 
	</div>
</div>




</body>
</html>
