<?php
	session_start();
if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
	include('logcheck.php');
	include('includes/conn.php');
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>John Paul College</title>

<link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" />
	

<link href = "style.css" rel = "stylesheet" type = "text/css"/>
<script type="text/javascript">
$('.confirm').live('click', function(){
    return confirm("Are you sure?");
});
</script>

	<script src="js/jquery-1.7.min.js"></script>

	<script src="js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="js/jquery.easing.1.3.js"></script>

  <style type="text/css">
			@import "css/demo_table_jui.css";
            @import "css/jquery-ui-1.8.4.custom.css";
    </style>
        
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                $('#datatables').dataTable({
                    "sPaginationType":"full_numbers",
                    "aaSorting":[[2, "desc"]],
                    "bJQueryUI":true
                });
            })
        </script>
</head>

<?php

?>

<body>

<div class='header'>
</div>
	
<nav class='container'>
<?php
include('includes/menu1.php');
?>
</nav>





<div id="main">
	<div class="shell">
	<div style='float:left; margin-left: 350px;'><center><b><h1>Subjects List</h1></b></center></div>
	<div style='float:right; margin-right:25px; margin-bottom:20px;'><a href='addnewsubj.php'><img src='iconadd2.png' width='50' ></a></div>
		<form method="post" class="niceform" >

		
		 <table id="datatables" class="display">
             <thead>
				<th>Subject Code</th>
             	<th>Subject Name</th>
             	<th># of Units</th>
				<th>Action</th>
              </thead>    
              <tbody>
					 <?php
				$getusers=mysql_query("SELECT * FROM subjecttbl");
				if(mysql_num_rows($getusers)==0)
				{
				echo"<tr>
						<td colspan ='4' align='center'>
							No Entries
						</td>
					</tr>";
				}
				else
				{
				while($getrows=mysql_fetch_array($getusers))
					{
					echo"<tr>
							<td>$getrows[subjectcode]</td>
							<td>$getrows[subjecttitle]</td>
							<td>$getrows[numofunits]</td>";
					?>
							 <td><form method='post' action='deletecurrsubj.php' onsubmit="return confirm('Are you sure?');"><input type='hidden' name='accid' value='<?php echo (int)$getrows['ID']; ?>'><input type='hidden' name='csrf' value='<?php echo htmlspecialchars($_SESSION['csrf'],ENT_QUOTES,'UTF-8'); ?>'><button type='submit'>DELETE</button></form></td>
						</tr>
						<?php
					}
				}
			 ?>
				</tbody>
		</table>
    
</form>
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