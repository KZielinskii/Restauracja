<?php
    session_start();

    if(isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<link rel="stylesheet" href="style.css" type="text/css" />
    <title>RESTAURACJA VINOSTEK - Menu</title>
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
        <div id="menu">

            <div id="top"></div>
            <div id="left_min"></div>
            <div id="center_max">
                <div id="header">
                    Kontakt:
                </div>
                <div id="contact">

                    Telefon: </br>
                    +48 500600700 </br>
                    </br>
                    E-mail: </br>
                    vinostek.wysylka@gmail.com </br>
                    vinostek.opinie@gmail.com </br>
                    vinostek@gmail.com </br>

                </div>
                <div id="address">
                    Adres: </br>
                    Ul. Piotrkowska 123 </br>
                    90-100 Łódź

                </div>
            </div>
            <div id="right_min"></div>
            
        </div>
    </div>

</body>
</html>