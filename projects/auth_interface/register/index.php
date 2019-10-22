<!DOCTYPE html>
<html lang='en'>

<head>

    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta name='author' content='Jean-Christophe Chevalier'>

    <title>Login interface</title>
    <link rel='icon' href='../../../img/favicon.png'/>

    <link rel='stylesheet'
          href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'
          integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm'
          crossorigin='anonymous'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:200|Quicksand' rel='stylesheet'>


    <link rel='stylesheet' href='../css_js/style.css'/>

</head>

<body>

<?php
require_once "../credentials.php";
$con = mysqli_connect($host, $user, $password, $database);
unset($host, $user, $password, $database);
?>

<div class='background-1'>
    <div class='jumbotron central' style='padding-bottom: 0'>

        <h1>Register now!</h1>
        <hr>

        <form name='login_form' action='' method='post'>

            <div class='form-group'>
                <label for='login'></label>
                <input type='text' id='login' name='login' class='form-control' placeholder='Login'

                    <?php
                    if (isset($_POST['login'])) {
                        echo "value='" . $_POST['login'] . "'";
                    }
                    else {
                        echo "value=''";
                    }
                    ?>

                />

                <?php
                if (isset($_POST['login'])) {
                    $query = 'SELECT * FROM members WHERE login = (?)';
                    $stmt = mysqli_prepare($con, $query);
                    mysqli_stmt_bind_param($stmt, "s", $_POST['login']);
                    mysqli_stmt_execute($stmt);
                    if (mysqli_stmt_fetch($stmt) == NULL) {
                        echo "<small class='form-text' style='color: darkgreen'>This ID is available !</small>";
                        $valid_id = true;
                    }
                    else {
                        echo "<small class='form-text' style='color: darkred'>This ID is already used by someone else.<br>Please use another ID</small>";
                        $valid_id = false;
                    }
                }
                ?>

            </div>

            <div class='form-group'>
                <label for='password'></label>
                <input type='password'  id='password' name='password' class='form-control' placeholder='Password' />

                <?php
                if (isset($_POST['password']) && isset($_POST['password2'])) {
                    if (strcmp($_POST['password'], $_POST['password2']) != 0) {
                        echo "<small class='form-text' style='color: darkred'>The passwords entered must be identical</small>";
                        $valid_pass = false;
                    }
                    else if (strlen($_POST['password']) < 8){
                        echo "<small class='form-text' style='color: darkred'>The password must contain at least 8 characters</small>";
                        $valid_pass = false;
                    }
                    else {
                        echo "<small class='form-text' style='color: green'>Valid password</small>";
                        $valid_pass = true;
                    }
                }
                ?>

            </div>

            <div class='form-group'>
                <label for='password2'></label>
                <input type='password'  id='password2' name='password2' class='form-control' placeholder='Confirm password' />
            </div>

            <button type='submit' name='submit' id='register-button' class='btn btn-success btn-lg'>Register</button>

        </form>

        <a href="../" target="_self"><button type='button' id="connect-button" class='btn btn-link'>Connect here</button></a>

    </div>
</div>

<?php
if (($valid_id == 1) && ($valid_pass == 1)) {

$hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$query = 'INSERT INTO members (login, password) VALUES (?, ?)';
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "ss", $_POST['login'], $hash_password);
mysqli_stmt_execute($stmt);

$query = 'SELECT id FROM members WHERE login = ?';
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $_POST['login']);
mysqli_stmt_bind_result($stmt, $file);
mysqli_stmt_execute($stmt);
if (mysqli_stmt_fetch($stmt)) {
    $filename = '../files/' . $file . '/';
    if(!is_dir($filename)){
        mkdir($filename);
        mkdir($filename . '/profile/');
        mkdir($filename . '/data/');
    }
}
header('Location: ../?login=' . $_POST['login']);
exit;
}
?>

</body>

</html>
