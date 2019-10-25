<?php
session_start();
unset($_SESSION);
session_destroy();
header('Location: https://www.jcchevalier.fr/projects/auth_interface/');
