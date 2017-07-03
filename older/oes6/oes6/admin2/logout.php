<?php
$PATH="http://".$_SERVER['HTTP_HOST']."/oes/";
session_start();
session_destroy();
header("Location:$PATH");
?>
