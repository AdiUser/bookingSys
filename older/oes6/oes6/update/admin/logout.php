<?php
$PATH="http://".$_SERVER['HTTP_HOST']."/oes1/";
session_start();
session_destroy();
header("Location:$PATH");
?>
