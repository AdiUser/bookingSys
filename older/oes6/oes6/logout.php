<?php
$PATH="http://".$_SERVER['HTTP_HOST']."/oes5/admin";
session_start();
session_destroy();
echo "<script>window.close();window.location='index.php'</script>"
//header("Location:$PATH");
?>
