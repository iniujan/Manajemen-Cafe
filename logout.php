<?php
session_start();
session_destroy();
header('Location: /resto/login.php');
exit;