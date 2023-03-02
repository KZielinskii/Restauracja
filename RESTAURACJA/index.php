<?php
    session_start();

    if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true))
    {
        header('Location: menu.php');
        exit();
    }
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<link rel="stylesheet" href="style.css" type="text/css" />
    <title>RESTAURACJA VINOSTEK - zamów jedzenie z dowozem do domu!</title>
</head>
<body>
    <div id="container">
        <div class="menu">
            <div class="dropdown">
                <a href="http://localhost/RESTAURACJA/menu_nolog.php">Menu</a>
                <ul>
                    <li><a href="menu_nolog.php#appetizer">Przystawki</a></li>
                    <li><a href="menu_nolog.php#steaks">Steki</a></li>
                    <li><a href="menu_nolog.php#wine">Wino</a></li>
                </ul>
                <a href="opinie_nolog.php">Opinie</a>
                <a href="kontakt_nolog.php">Kontakt</a>
            </div>
            <a id="a_register" href="rejestracja.php">Zarejestruj się!</a>
        </div>
        <div id="logo">
            <a href="http://localhost/RESTAURACJA/index.php"><img src="graphic/logo.png" alt="Logo - WinoStek" width="200" height="100"></a>
        </div>
            <div id="left"></div>

            <div id="center">
                <div id="top">
                </div>
                <div id="login">
                    <br /><br />
                    <img src="graphic/user.png" alt="Logowanie - obraz profilowy" width="200" height="200">
                    <form action="zaloguj.php" method="post">
                        <br />
                        Login: <br /><input type="text" name="login" /><br />
                        Hasło: <br /><input type="password" name="haslo" /><br /><br />
                        <input id="button_login" type="submit" value="Zaloguj się" /><br />
                        <div id="error">
                        <?php
                            if(isset($_SESSION['error']))
                            echo $_SESSION['error'];
                        ?>
                        </div>
                        <br /><br />
                    </form>
                </div>
            </div>
            <div id="right"></div>
    </div>

</body>
</html>