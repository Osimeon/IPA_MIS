<?php
function check_required_fields($required_array)
{
$field_errors=array();
foreach($required_array as $fieldname)
{
if((!isset($_POST[$fieldname])||(strlen($_POST[$fieldname])<=0))||(empty($_POST[$fieldname])&&$_POST[$fieldname]!=0)) 
{
$field_errors[]=$fieldname;
}
}
return $field_errors;
}


function check_max_field_lengths($field_length_array)
{
$field_errors=array();

foreach($field_length_array as $fieldname=>$maxlength)
{

if(strlen(trim(mysql_prep($_POST[$fieldname])))>$maxlength)
{
$field_errors[]=$feildname;
}
return $field_errors;
}
}

function check_password_match($password,$confirm_password)
{

if($password==$confirm_password)
{
return true;
}
else
{
return false;
}

}

function valid_email($email)
{
 
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!@ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
    {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++)
    {
        if (!@ereg("^(([A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
            $local_array[$i]))
        {
            return false;
        }
    }
    if (!@ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
    { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2)
        {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++)
        {
            if (!@ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]))
            {
                return false;
            }
        }
    }
    return true;
}

function display_error($fieldname,$errors)
{
if(in_array($fieldname,$errors))
{
echo "<span class='error'>*</span>";
}
}

function generate_options($query,$row_id)
{
$result_set=get_result_set($query);
while($row=mysql_fetch_array($result_set))
{
echo "<option value='{$row['id']}'>{$row['name']}</option>";
}

}
?>