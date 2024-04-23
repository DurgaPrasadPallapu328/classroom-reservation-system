<?php
require_once '../includes/session.php';

if (isLoggedIn()) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}

header('Location: ../index.php');
exit;
