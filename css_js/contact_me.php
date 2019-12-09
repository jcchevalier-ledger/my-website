<?php
if (isset($_POST['email']) && isset($_POST['bmessage'])) {

    $to = "jean.christophe.chevalier.3@gmail.com";
    $subject = "Someone tried to contact you !";
    $txt = $_POST['bmessage'];
    $headers = "From: " . $_POST['email'] . "\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\n";
    $headers .= "Content-type: text/html; charset=utf-8\n";

    mail($to,$subject,$txt,$headers);
}
