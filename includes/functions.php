<?php error_reporting(E_ALL ^ E_NOTICE);?>
<?php
//session
session_start();
function createRandomPassword() 
{
$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i = 0;
$pass = '' ;
while ($i <= 7) {
$num = rand() % 33;
$tmp = substr($chars, $num, 1);
$pass = $pass . $tmp;
$i++;
}
return $pass;
}
function mysql_prep($value)
{
$magic_quotes_active=get_magic_quotes_gpc();
$new_enough_php = function_exists("mysql_real_escape_string");//php is later than 4.3

if($new_enough_php)
{
//undo magic quotes so real escape can do the work
if($magic_quotes_active){$value=stripslashes($value);}
$value=mysql_real_escape_string($value);

}else
{
if(!magic_quotes_active){$value=addslashes($value);}
}
return trim($value);
}
function confirm_query($result_set)
{
if(!$result_set)
{
die("Database query failed:  ".mysql_error());
}
}
function get_result_set($query)
{
$result_set=mysql_query($query);
confirm_query($result_set);
return $result_set;
}
function get_row($query)
{
$row=mysql_fetch_array(get_result_set($query));
return $row;
}
?>