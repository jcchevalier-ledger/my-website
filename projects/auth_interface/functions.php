<?php
function isValidEmail($email)
{
    if (preg_match("/^([\w-]+)@((?:[\w]+\.)+)([a-zA-Z]{2,4})/i", $email)) {
        return true;
    } else {
        return false;
    }
}
