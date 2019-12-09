<?php session_start();
require_once "credentials.php";
require_once "functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Jean-Christophe Chevalier's resume, Computer Science Student">
    <meta name="author" content="Jean-Christophe Chevalier">

    <title>Login interface</title>
    <link rel="icon" href="../../img/favicon.png"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200|Quicksand" rel="stylesheet">


    <link rel="stylesheet" href="css_js/style.css"/>

</head>

<body>

<?php
$con = mysqli_connect($host, $user, $password, $database);
unset($host, $user, $password, $database);
$display_id = true;

if (isset ($_GET["login"])) {
    $alert_displayed = createAlert("Your account has been successfully created. You can now login on this page!", "primary");
    $login = "value='" . $_GET['login'] . "'";
}

if ((isset ($_POST["login"]) && isset ($_POST["password"]))) {

    $result = array();
    $display_id = false;

    $stmt = mysqli_prepare($con, "SELECT id, password, first_name, last_name, email, profile_pict FROM members WHERE login = ?");
    mysqli_stmt_bind_param($stmt, "s", $_POST["login"]);
    mysqli_stmt_bind_result($stmt, $result['id'], $result['password'], $result['first_name'], $result['last_name'], $result['email'], $result['profile_pict']);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_fetch($stmt)) {
        if (password_verify($_POST["password"], $result['password'])) {
            $_SESSION['id'] = $result['id'];
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['first_name'] = $result['first_name'];
            $_SESSION['last_name'] = $result['last_name'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['profile_pict'] = $result['profile_pict'];
            unset($_POST, $result, $_GET);
        } else {
            $alert_displayed = createAlert("Wrong login or password", "danger");
        }
    } else {
        $alert_displayed = createAlert("Wrong login or password", "danger");
    }
}

if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
    echo "
<nav id='navbar' class='navbar navbar-expand navbar-light fixed-top justify-content-between'>
    <a class='navbar-brand'>
        <img src='../../../img/avatar/avatar.png' class='profile-img rounded-circle' alt=''>
    </a>
    <div>
        <a class='nav-link' href='profile' target='_self' style='display: inline-block'>Your profile</a>
        <a href='logout.php' style='display: inline-block'>
            <button  type='button' class='btn btn-danger'>Logout</button >
        </a>
    </div>
</nav>


<div class='background-1'>    
	<div class='jumbotron central' style='padding-bottom: 0'>

		<h1>Welcome, {$_SESSION['login']}</h1>
		<hr>
		<p>You are now logged on my platform. </p>
		
	</div>
</div>";

} else {
    echo "
<div class='background-1'>
	<div class='jumbotron central' style='padding-bottom: 0'>

		<h1>Login interface</h1>
		<hr>

		<form name='login_form' action='' method='post'>

			<div class='form-group'>
				<label for='login'></label>
				<input type='text' id='login' name='login' class='form-control' placeholder='Login' {$login} required/>
			</div>

			<div class='form-group'>
				<label for='password'></label>
				<input type='password'  id='password' name='password' class='form-control' placeholder='Password' required/>
			</div>

			<button type='submit' id='login-button' class='btn btn-success btn-lg'>Login</button>

		</form>

	 <a href='register' target='_self'><button type='button' id='create-account' class='btn btn-link'>Create account</button></a>

	</div>
</div>";
    echo $alert_displayed;
}
?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>

</html>
