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
        <div id="center_menu">
            <div id="header">
                <a id="appetizer">Opinie:</a>
            </div>
            <div id="padding">
                <div id="left_frame_op"></div>
                <a href="index.php">
                    <div id="frame_op">
                        <div id="block">
                            Dodaj opinie.
                        </div>
                    </div>
                </a>
                <div id="clear"></div>
            </div>
            <?php
            require_once "connect.php";
            mysqli_report(MYSQLI_REPORT_STRICT);
            $connected = new mysqli($host, $db_user, $db_password, $db_name);
            if($connected->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                $result = $connected->query("SELECT * FROM opinions inner join users on users.ID = opinions.LoginID");
                if (!$result) throw new Exception($connected->error);
                $how_many = $result->num_rows;
                $opinion = mysqli_fetch_all($result,MYSQLI_ASSOC);
                for($i=0; $i<$how_many; $i++)
                {
                        echo
                        '
                        <div id="left_frame"></div>
                        <div id="frame_com">
                            <div id="block">
                                    <div id="com_text">
                                    <br/>
                                    <input id="opinion" type="text" name="nazwa" value="'; print($opinion[$i]["text"]); echo'" disabled>
                                    </div>
                                    <br/>
                                    
                                    <div id="description_add_to_cart">
                                    ';
                        print($opinion[$i]["name"]);
                        echo(" ");
                        print($opinion[$i]["surename"]);
                        echo
                        '
                                    </div>
                            </div>
                            </a>
                        </div>
                        <div id="right_frame"></div>
                            ';
                }
                mysqli_free_result($result);
                $connected->close();
            }
            ?>
        </div>
        <div id="right_min"></div>
    </div>
</div>

</body>
</html>