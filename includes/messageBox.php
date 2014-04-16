<?php
if(isset($messageToUser))
{
echo "<div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;background-color:#a2ff7e;'>{$messageToUser}</div>";
}
if(isset($error_message))
{
echo "<div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #ff0404;background-color:#ffc0c0;'>{$error_message}</div>";
}
?>