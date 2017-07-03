<?php
$hostname = 'localhost';
$username = 'root';
$password = 'toor';

$db = mysql_connect($hostname, $username, $password)
  or die("Unable to connect to MySQL");

/**
 * Converts fields contained into $fields array on the table $table on the db $dbname to blob than to utf8.
 * This is the procedure to follow when convert the field encoding when it's different than utf8 (eg latin1) while it already contains utf8 data inside
*/
function convert_to_utf8($dbname, $tables_fields) {

  foreach($tables_fields as $table => $fields) {
    foreach($fields as $field) {
      // convert each field to BLOB
      myq('ALTER TABLE ' . $dbname . '.' . $table . ' MODIFY ' . $field . ' BLOB');
    }
  }
  myq("ALTER DATABASE $dbname charset=utf8");
  
  foreach($tables_fields as $table => $fields) {
    myq('ALTER TABLE ' . $dbname . '.' . $table . ' charset utf8');
  }
  
  foreach($tables_fields as $table => $fields) {
    foreach($fields as $field) {
      // convert each field to utf8
      myq('ALTER TABLE ' . $dbname . '.' . $table . ' MODIFY ' . $field . ' TEXT CHARACTER SET utf8');
    }
  }
  
  print "converted to utf8 db" . $dbname ."\n";
}

function myq($query) {
  $result = mysql_query($query) or die("error: " . mysql_error() . "\nQuery: " . $query);
  return $result;
}

$table_fields = array(
  'adminlogin' => array('admname', 'admpassword'),
  'sett' => array('key', 'metadata'),
  'student' => array('stdname', 'stdpassword', 'emailid', 'contactno', 'address', 'city', 'pincode', 'batch'),
  'studentquestion' => array('stdanswer'),
  'studenttest' => array('status'),
  'subject' => array('subname','subdesc'),
  'subj_question' => array('level', 'question', 'figure', 'optiona', 'optionb', 'optionc', 'optiond', 'optione', 'correct', 'type'),
  'test' => array('testname','testdesc','testcode'),
  );

convert_to_utf8('oes', $table_fields);
?>