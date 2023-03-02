<?php
    session_start();

    if(isset($_SESSION['successfuladding']))
    {
        header('Location: index.php');
        exit();
    }
    else
    {
        unset($_SESSION['successfuladding']);
    }

    //usuwanie zmiennych zapamiętanych
    if(isset($_SESSION['fr_login']))unset($_SESSION['fr_login']);
    if(isset($_SESSION['fr_name']))unset($_SESSION['fr_name']);
    if(isset($_SESSION['fr_surename']))unset($_SESSION['fr_surename']);
    if(isset($_SESSION['fr_telephone']))unset($_SESSION['fr_telephone']);
    if(isset($_SESSION['fr_city']))unset($_SESSION['fr_city']);
    if(isset($_SESSION['fr_email']))unset($_SESSION['fr_email']);
    if(isset($_SESSION['fr_password1']))unset($_SESSION['fr_password1']);
    if(isset($_SESSION['fr_password2']))unset($_SESSION['fr_password2']);
    if(isset($_SESSION['fr_street']))unset($_SESSION['fr_street']);
    if(isset($_SESSION['fr_buildingnumer']))unset($_SESSION['fr_buildingnumer']);
    if(isset($_SESSION['fr_apartamentnumber']))unset($_SESSION['fr_apartamentnumber']);
    if(isset($_SESSION['fr_statute']))unset($_SESSION['fr_statute']);

    //usuwanie błędów rejestracji
    if(isset($_SESSION['e_login']))unset($_SESSION['e_login']);
    if(isset($_SESSION['e_name']))unset($_SESSION['e_name']);
    if(isset($_SESSION['e_surename']))unset($_SESSION['e_surename']);
    if(isset($_SESSION['e_telephone']))unset($_SESSION['e_telephone']);
    if(isset($_SESSION['e_city']))unset($_SESSION['e_city']);
    if(isset($_SESSION['e_email']))unset($_SESSION['e_email']);
    if(isset($_SESSION['e_password']))unset($_SESSION['e_password']);
    if(isset($_SESSION['e_statute']))unset($_SESSION['e_statute']);

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<link rel="stylesheet" href="style.css" type="text/css" />
    <title>Restauracja WinoStek - zamów jedzenie z dowozem do domu!</title>
</head>
<body>

    DZIĘKUJEMY ZA REJESTRACJĘ!<br />
    <a href="index.php">Zaloguj się na swoje konto :)</a>




</body>
</html>