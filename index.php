<?php
require 'autoloader.php';
require 'includes/functions.php';

$db = Database::connect();
$session = new Session();

if ($session->is_logged_in()) {
    header('Location: admin');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Visitors</title>
	<link rel="stylesheet" href="vendor/bootstrap-4.3.1-dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="vendor/bootstrap-4.3.1-dist/js/bootstrap.min.js"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h2 class="main-heading text-center">Visitor tracking site</h2>
<div class="container">
	<div class="row">
		<div class="col-md text-center"><a class="btn btn-success" href="admin">View Visitors data</a></div>
	</div>
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<div class="jumbotron text-center">
				<h3>Collecting your data...</h3>
				<div class="loader ml-auto mr-auto"></div>
				<p class="small text-left description"></p>
			</div>
		</div>
	</div>
</div>


<?php
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $user_agent = $_SERVER['HTTP_USER_AGENT'] . '</li>';
} else {
    $user_agent = '';
}

$remote_address = $_SERVER['REMOTE_ADDR'];
$remote_host = gethostbyaddr($remote_address);
preg_match('/\((.*?)\)/', $_SERVER['HTTP_USER_AGENT'], $operating_system);
?>
<script src="track_user/track_user.js"></script>
</body>
</html>

<?php
//Check if user already accessed this site and if cookie is set
if (isset($_COOKIE['user_id'])) {
    //Find data about visitor in database table
    $visitor = Visitor::find($_COOKIE['user_id']);

    if ($visitor === false) {
        setcookie('user_id', false, time() - 1, '/visitors');
        $not_in_db = true;
    } else {
        $not_in_db = false;
        $visitor->visit_count++;
        $visitor->update();
    }
}

//If cookie is not set or visitor cookie does not exist in database table
if (!isset($_COOKIE['user_id']) || $not_in_db === true) {
    $unique_id = generateRandomString(15);
    $time = time() + 31536000;
    setcookie('user_id', $unique_id, $time, '/visitors');

    $visitor = new Visitor();
    $visitor->unique_id = $unique_id;
    $visitor->user_agent = $_SERVER['HTTP_USER_AGENT'];
    $visitor->operating_system = $operating_system[1];
    $visitor->remote_addr = $_SERVER['REMOTE_ADDR'];
    $visitor->remote_host = $remote_host;
    $visitor->visit_count = 1;
    $visitor->save();
}
?>
