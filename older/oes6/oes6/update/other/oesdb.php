

<?php

include_once 'dbsettings.php';
$conn=false;


$PATH="http://".$_SERVER['HTTP_HOST']."/oes5";
$PATH_ADMIN="http://".$_SERVER['HTTP_HOST']."/oes5/admin";

function executeQuery($query)
{
    global $conn,$dbserver,$dbname,$dbpassword,$dbusername;
    global $message;
    if (!($conn = @mysql_connect ($dbserver,$dbusername,$dbpassword)))
         $message="Cannot connect to server";
    if (!@mysql_select_db ($dbname, $conn))
         $message="Cannot select database";

	mysql_query("SET character_set_results=utf8", $conn);
    mb_language('uni'); 
    mb_internal_encoding('UTF-8');
	
    $result=mysql_query($query,$conn);
    if(!$result)
        $message="Error while executing query.<br/>Mysql Error: ".mysql_error();
    else
        return $result;

}
function closedb()
{
    global $conn;
    if(!$conn)
    mysql_close($conn);
}
?>
