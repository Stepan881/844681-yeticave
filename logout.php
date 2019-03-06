<?php
require_once('functions/db.php');
$config = require('config.php');

session_start();

unset($_SESSION['user']);
header("Location: /index.php");
