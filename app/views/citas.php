<?php 
require_once '../session/sessionManager.php';


if(! isAuthenticated()){
    header("Location: login.php");
    exit;
}

$user = getUser();

echo "Bienvendida, " . $user['name'];

?>
