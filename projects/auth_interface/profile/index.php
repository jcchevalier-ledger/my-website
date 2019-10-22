<?php session_start(); ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Jean-Christophe Chevalier's resume, Computer Science Student">
        <meta name="author" content="Jean-Christophe Chevalier">

        <title>Login interface</title>
        <link rel="icon" href="../../../img/favicon.png"/>

        <link rel="stylesheet"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:200|Quicksand" rel="stylesheet">


        <link rel="stylesheet" href="../css_js/style.css"/>

    </head>

    <body>

<?php
require_once "../credentials.php";
if (isset($_SESSION["login"]) && isset($_SESSION["id"])) {

    $con = mysqli_connect($host, $user, $password, $database);
    unset($host, $user, $password, $database);

    if (isset($_POST['change']) && $_POST['change'] == 'Modify') {
        $readonly_value = '';
        $btn_value = 'Save changes';
        $display = '';
    } else if (isset($_POST['change']) and $_POST['change'] == 'Save changes') {
        $update = mysqli_prepare($con, 'UPDATE members SET login = ?, first_name = ?, last_name = ?, email = ? WHERE id = ?');
        mysqli_stmt_bind_param($update, 'ssssi', $_POST['username'], $_POST['first-name'], $_POST['last-name'], $_POST['email'], $_SESSION['id']);
        mysqli_stmt_execute($update);
        mysqli_stmt_close($update);

        $_SESSION['login'] = $_POST['username'];
        $_SESSION['first_name'] = $_POST['first-name'];
        $_SESSION['last_name'] = $_POST['last-name'];
        $_SESSION['email'] = $_POST['email'];

        mysqli_close($con);

        header('Location: https://www.jcchevalier.fr/projects/auth_interface/profile');

    } else {
        $btn_value = 'Modify';
        $readonly_value = 'readonly';
        $display = 'display: none';
    }

    echo "
<nav id='navbar' class='navbar navbar-expand navbar-light fixed-top justify-content-between'>
    <a class='navbar-brand'>
        <img src='{$_SESSION['profile_pict']}' class='profile-img rounded-circle' alt=''>
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
                            
        <form method='post' action=''>
        
            <div class='row' style='width: 100%; margin: 0'>    
                                
                <div class='col-sm-7'>
                    <div class='form-group row'>
                        <label for='username' class='mx-sm-3 col-sm-2'>Login</label>
                        <input type='text' class='col-sm-7 form-control' name='username' value='{$_SESSION['login']}' {$readonly_value}>
                    </div>
                    <div class='form-group row'>
                        <label for='first-name' class='mx-sm-3 col-sm-2'>First name</label>
                        <input type='text' class='col-sm-7 form-control' name='first-name' value='{$_SESSION['first_name']}' {$readonly_value}>
                    </div>
                    <div class='form-group row'>
                        <label for='last-name' class='mx-sm-3 col-sm-2'>Last name</label>
                        <input type='text' class='col-sm-7 form-control' name='last-name' value='{$_SESSION['last_name']}' {$readonly_value}>
                    </div>
                    <div class='form-group row'>
                        <label for='email' class='mx-sm-3 col-sm-2'>Email address</label>
                        <input type='email' class='col-sm-7 form-control' name='email' value='{$_SESSION['email']}' {$readonly_value}>
                    </div>
                </div>
                
                <div class='col-sm-1' style='width: 0;'></div>
                
                <div class='col-sm-3'>
                    <div style='padding: 0; margin: auto; {$display}'>
                        <input id='password-change' type='submit' class='btn btn-danger' value='Change password' name='password-change' style='white-space: nowrap;'>
                    </div>
                    <img src={$_SESSION['profile_pict']} class='big-profile-img rounded-circle' alt=''>
                    <form method='post'>
                        <button type='submit' class='fa fa-pencil-square-o' id='modify' name='profile-change' style='{$display}'></button>
                    </form>
                </div>
                
                <div class='col-sm-1'></div>
                
                <input type='submit' class='btn btn-danger' value='{$btn_value}' name='change'>

                
            </div>
            
        </form>
        
	</div>
</div>";

    if (isset($_POST["logout"])) {
        unset($_SESSION);
        session_destroy();
        header('Location: https://www.jcchevalier.fr/projects/auth_interface/');
    }
} else {
    header('Location: https://www.jcchevalier.fr/projects/auth_interface/');
}
?>
