<?php
session_start();
include('conn.php');

if (isset($_POST['submit'])) {
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $stmt = $mysqli->prepare('SELECT * FROM usertbl WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && (password_verify($password, $user['password']) || hash_equals((string)$user['password'], $password))) {
        session_regenerate_id(true);
        $_SESSION['username'] = $user['username'];
        $_SESSION['type'] = $user['user_type'];
        $_SESSION['logcheck'] = 1;
        $_SESSION['userID'] = (int)$user['ID'];
        header('Location: ' . ($user['user_type'] === 'admin' ? 'Admin/adminindex.php' : 'student/studentindex.php'));
        exit;
    }
    $loginError = 'Invalid username or password.';
}

?>
<!doctype html>
<html>
<head>
<title>LOGIN PAGE</title>

<link href="style.css" rel="stylesheet" type="text/css"/>

</head>
<body>

	<div class="loginForm" align="center">

	<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;System Login</h1>

<?php if (!empty($loginError)) echo '<p role="alert">'.htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8').'</p>'; ?>
<form method="POST">
<div style="float:left; margin-top: -40px; margin-left: 40px;">
<img src="logo.jpg" width="160" height="110">
</div>
<div style="margin-left: auto; margin-right: auto;">

	<br>
	<b>Username:</b>
	<input type="text" class="text" required="required" name="username"/>
	<br><br>
	<b>Password :</b>

	<input type="password" class="text" required="required" name="password"/>
	<br><br>
	<input type="submit" name="submit" value="Login" class="btn"/>
</div>
</form>
</div>
</body>
</html>