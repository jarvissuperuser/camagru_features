<?php
session_start();

$projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
require $projectRoot.'Sources/BackEnd/controller/relativePathController.php';


$dbc = new DB_Control();
$u = new User($dbc);
$u->email = $_SESSION['email'];
$u->password = $_SESSION['password'];
$u->hashed = 1;

echo json_encode(['test'=>$_SESSION,'msg'=>'testing','no'=>$u->verify()]);