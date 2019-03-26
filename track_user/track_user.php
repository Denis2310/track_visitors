<?php
require '../autoloader.php';

$db = Database::connect();

$time = $_POST['time_spent'];
$clicks = $_POST['clicks'];
$visitor = Visitor::find($_COOKIE['user_id']);
if ($visitor) {
    $visitor->time_spent += $time;
    $visitor->clicks = $clicks;
    $visitor->updateUserActivity();
}
