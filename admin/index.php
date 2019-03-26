<?php
require '../autoloader.php';

$session = new Session();

if (!$session->is_logged_in()) {
    header('Location: admin_login.php');
}

$db = Database::connect();
//check admin login, if logged in pass, if not redirect to login
$visitors = Visitor::findAll();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../vendor/bootstrap-4.3.1-dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="admin_styles.css">
</head>
<body>
	<h2 class="main-heading text-center">Admin Area</h2>
	<div class="text-center"><button class="btn btn-primary"><a href="logout.php">Logout</a></button></div>
	<h3 class="text-center">Tracked visitors</h3>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Cookie ID</th>
							<th>User Agent</th>
							<th>Operating System</th>
							<th>Remote Address</th>
							<th>Remote Host</th>
							<th>First Access</th>
							<th>Last Access</th>
							<th>Total Time Spent On Site</th>
							<th>Mouse Clicks In Last Access</th>
							<th>Visits Counter</th>
						</tr>
					</thead>
					<tbody>
			<?php
if (is_array($visitors)) {
    foreach ($visitors as $visitor) {
        ?>
						<tr>
							<td><?php echo $visitor->id; ?></td>
							<td><?php echo $visitor->unique_id; ?></td>
							<td><?php echo $visitor->user_agent; ?></td>
							<td><?php echo $visitor->operating_system; ?></td>
							<td><?php echo $visitor->remote_addr; ?></td>
							<td><?php echo $visitor->remote_host; ?></td>
							<td><?php echo $visitor->first_access; ?></td>
							<td><?php echo $visitor->last_access; ?></td>
							<td><?php echo $visitor->time_spent . " s"; ?></td>
							<td><?php echo $visitor->clicks; ?></td>
							<td><?php echo $visitor->visit_count; ?></td>
						</tr>
			<?php
}
}
?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
