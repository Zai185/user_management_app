<?php
require '../bootstrap.php';
delete_session_token($_SESSION['uid']);
session_destroy();
redirect('auth/login.php');