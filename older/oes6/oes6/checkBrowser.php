<?php
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == false)
{
    echo "<script>alert('You are only allowed to use Google Chrome'); window.close(); window.location='logout.php'</script>";
}
?>
