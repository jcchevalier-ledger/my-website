<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Jean-Christophe Chevalier's resume, Computer Science Student">
    <meta name="author" content="Jean-Christophe Chevalier">

    <title>Login interface</title>

    <link rel="icon"
          href="../../../img/favicon.png"/>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:200|Quicksand"
          rel="stylesheet">

    <link rel="stylesheet"
          href="../css_js/style.css"/>

</head>

<body>

<?php
require_once "../credentials.php";
require_once "../functions.php";
if (isset($_SESSION["login"]) && isset($_SESSION["id"])) {

    $email = $_SESSION['email'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];

    $con = mysqli_connect($host, $user, $password, $database);
    unset($host, $user, $password, $database);

    $email = $_SESSION['email'];
    $btn_value = 'Modify';
    $readonly_value = 'readonly';
    $display = 'display: none';
    $isValidMail = true;

    if (isset($_POST['change']) && strcmp($_POST['change'], 'Modify') == 0) {
        $readonly_value = '';
        $btn_value = 'Save changes';
        $display = '';
    } else if (isset($_POST['change']) and strcmp($_POST['change'], 'Save changes') == 0) {

        $btn_value = 'Save changes';
        $readonly_value = '';
        $display = '';

        if (isset($_POST['email']) and strcmp($_POST['email'], $_SESSION['email']) !== 0) {
            if (isValidEmail($_POST['email'])) {
                $input_mail = 'valid-input';
            } else {
                $input_mail = 'invalid-input';
                $isValidMail = false;
                $email = $_POST['email'];
                $last_name = $_POST['last-name'];
                $first_name = $_POST['first-name'];
            }
        }

        if ($isValidMail) {
            $update = mysqli_prepare($con, 'UPDATE members SET first_name = ?, last_name = ?, email = ? WHERE id = ?');
            mysqli_stmt_bind_param($update, 'sssi', $_POST['first-name'], $_POST['last-name'], $_POST['email'], $_SESSION['id']);
            mysqli_stmt_execute($update);
            mysqli_stmt_close($update);

            $_SESSION['first_name'] = $_POST['first-name'];
            $_SESSION['last_name'] = $_POST['last-name'];
            $_SESSION['email'] = $_POST['email'];

            mysqli_close($con);

            header('Location: https://www.jcchevalier.fr/projects/auth_interface/profile');
        }
    }
}
?>

<nav id='navbar' class='navbar navbar-expand navbar-light fixed-top justify-content-between'>
    <a class='navbar-brand'>
        <img src='<?php echo $_SESSION['profile_pict'] ?>' class='profile-img rounded-circle' alt=''>
    </a>
    <a class='title'>
        <?php echo $_SESSION['login'] ?>
    </a>
    <form class='form-inline' method='post'>
        <a class='nav-link' href='https://www.jcchevalier.fr/projects/auth_interface/' target='_self'>Home</a>
        <input type='submit' name='logout' class='btn btn-danger' value='Logout'>
    </form>
</nav>

<div class='background-1'>
    <div class='jumbotron central'>

        <h1>Your profile</h1>
        <hr>
        <p class='my-3'>Here you have an access to your personal data</p>

        <form method='post' action='' id="form" novalidate>

            <div class='row' style='width: 100%; margin: 0'>

                <div class='col-sm-7'>
                    <div class='form-group row'>
                        <label for='first-name' class='mx-sm-3 col-sm-2'>First name</label>
                        <label class="col-sm-7">
                            <input type='text' class='form-control' name='first-name'
                                   value='<?php echo $first_name ?>' <?php echo $readonly_value ?>>
                        </label>
                    </div>
                    <div class='form-group row'>
                        <label for='last-name' class='mx-sm-3 col-sm-2'>Last name</label>
                        <label class="col-sm-7">
                            <input type='text' class='form-control' name='last-name'
                                   value='<?php echo $last_name ?>' <?php echo $readonly_value ?>>
                        </label>
                    </div>
                    <div class='form-group row'>
                        <label for='email' class='mx-sm-3 col-sm-2'>Email address</label>
                        <label class="col-sm-7">
                            <input type='email' class='form-control <?php echo $input_mail ?>' name='email'
                                   value='<?php echo $email ?>' <?php echo $readonly_value ?>
                                   data-toggle="tooltip" data-placement="bottom" title="Invalid email">
                        </label>
                    </div>
                </div>

                <div class='col-sm-1' style='width: 0;'></div>

                <div class='col-sm-3'>
                    <div style='padding: 0; margin: auto; <?php echo $display ?>'>
                        <input id='password-change' type='button' class='btn btn-danger invalid' value='Change password'
                               name='password-change' style='white-space: nowrap;'>
                    </div>
                    <img src='<?php echo $_SESSION['profile_pict'] ?>' class='big-profile-img rounded-circle' alt=''>
                    <button type='button' class='fa fa-pencil-square-o' id='modify' name='profile-change'
                            style='<?php echo $display ?>'></button>
                </div>

                <div class='col-sm-1'></div>

                <input type='submit' class='btn btn-danger' value='<?php echo $btn_value ?>' name='change'>


            </div>

        </form>

    </div>
</div>

<script src="../css_js/profileActions.js"></script>

<?php
if (!$isValidMail) {
    echo "<script>$('[data-toggle=\"tooltip\"]').tooltip()</script>";
}
if (isset($_POST["logout"])) {
    unset($_SESSION);
    session_destroy();
    header('Location: https://www.jcchevalier.fr/projects/auth_interface/');
} else {
    header('Location: https://www.jcchevalier.fr/projects/auth_interface/');
    unset($_POST);
}
?>

</body>
