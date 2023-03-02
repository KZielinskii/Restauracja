<?php
    session_start();

    if(!isset($_SESSION['zalogowany']))
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
                <a href="menu.php">Menu</a>
                <ul>
                    <li><a href="menu.php#appetizer">Przystawki</a></li>
                    <li><a href="menu.php#steaks">Steki</a></li>
                    <li><a href="menu.php#wine">Wino</a></li>
                </ul>
                <a href="opinie.php">Opinie</a>
                <a href="kontakt.php">Kontakt</a>
                <?php
                if($_SESSION['login']=='admin')
                {
                    echo '<a href="admin.php">Panel administracyjny</a>';

                    require_once "connect.php";
                    mysqli_report(MYSQLI_REPORT_STRICT);
                    $connected = new mysqli($host, $db_user, $db_password, $db_name);
                    if($connected->connect_errno!=0)
                    {
                        throw new Exception(mysqli_connect_errno());
                    }
                    else
                    {
                        $result = $connected->query("SELECT * FROM todo GROUP BY LoginID");
                        if (!$result) throw new Exception($connected->error);
                        $how_many = $result->num_rows;
                        $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                    }

                    echo '<a href="admin_todo.php" class="notification2"> 
                        <span>Zamówienia </span>
                        <span class="badge2">
                                ';
                    echo($how_many);
                    echo'
                        </span>
                      </a>';
                }
                ?>
            </div>
            <div id="shop_cart">
                <a href="cart.php" class="notification">
                        <span>
                        <img src="graphic/koszyk.png" alt="koszyk sklepowy" width="75" height="75">
                        </span>
                    <span class="badge">
                            <?php
                            $print = $_SESSION['cart_capacity'];
                            echo($print)
                            ?>
                        </span>
                </a>
            </div>
            <a id="a_register" href="logout.php">Wyloguj się!</a>
        </div>
        <div id="logo">
            <a href="http://localhost/RESTAURACJA/index.php"><img src="graphic/logo.png" alt="Logo - VINOSTEK" width="200" height="100"></a>
        </div>
        <div id="menu">
            
        </div>
        <div id="footer">
            Tutaj bedzie stopka!
        </div>
    </div>

</body>
</html>