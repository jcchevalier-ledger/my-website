<?php
function isValidEmail($email)
{
    if (preg_match("/^([\w-\.]+)@((?:[\w]+\.)+)([a-zA-Z]{2,4})/i", $email)) {
        return true;
    } else {
        return false;
    }
}

function createAlert($text, $type)
{
    $alert = "<div class='alert alert-" . $type . " fixed-top alert-dismissible fade show' role='alert' style='opacity: 0.65'>"
        . $text . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times</span>
                   </button>
              </div>";

    return $alert;
}
