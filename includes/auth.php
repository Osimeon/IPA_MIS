<?php
session_start();
if (!isset($_SESSION['user_id'])){
header('location:index.php');
}
$session_user_id = "$_SESSION[user_id]";
$session_staff_name = "$_SESSION[staff_name]";
$session_emp_no = "$_SESSION[emp_no]";
$session_email = "$_SESSION[email]";
$session_role_id = "$_SESSION[role_id]";
$session_level_id = "$_SESSION[level_id]";
$session_regional_office_id = "$_SESSION[regional_office_id]";
$session_office_name = "$_SESSION[office_name]";
$session_country_code = "$_SESSION[country_code]";
$session_country_name = "$_SESSION[country_name]";
$session_tel_code = "$_SESSION[tel_code]";
$date = date("Y-m-d");
?>