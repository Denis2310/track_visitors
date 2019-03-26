<?php
require '../autoloader.php';
$db = Database::connect();
$session = new Session();

if ($session->is_logged_in()) {
    header('Location: admin');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../vendor/bootstrap-4.3.1-dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="admin_styles.css">
</head>
<body>
	<h2 class="text-center">Admin Area</h2>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
			<form method="post">
				<div class="input_container form-group">
					<label for="admin_username">Username:</label>
					<input class="form-control" type="text" id="admin_username" name="admin_username">
				</div>
				<div class="input_container form-group">
					<label for="admin_password">Password:</label>
					<input class="form-control" type="password" id="admin_password" name="admin_password">
				</div>
				<button class="btn btn-primary" type="submit" name="submit_login">Login</button>
				<button class="btn btn-secondary"><a href="/visitors">Back</a></button>
			</form>

			</div>
		</div>
	</div>


</body>
</html>

<?php

if (isset($_POST['submit_login'])) {

    $username = trim($_POST['admin_username']);
    $password = trim($_POST['admin_password']);
    $sql = "SELECT * FROM admin WHERE username=? AND password=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$username, $password]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['logged_in'] = true;
        header('Location: /visitors/admin');
    }
}

?>