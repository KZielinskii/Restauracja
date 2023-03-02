<?php
    session_start();

    if(!isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
        exit();
    }
    if($_SESSION['login']!='admin')
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
    <title>RESTAURACJA VINOSTEK - zamów jedzenie z dowozem do domu!</title>
</head>
<body>

<div id="menu">

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

    <div id="top"></div>
    <div id="left_min"></div>
    <div id="center_menu">
        <div id="header">
            Panel administracyjny:
        </div>
        </br>
        <div id="left_frame_op"></div>
        <a href="admin_add.php">
            <div id="frame_op">
                <div id="block">
                    Dodaj produkt do menu.
                </div>
            </div>
        </a>
        <div id="right_frame_op"></div>
        <div id="left_frame_op"></div>
        <a href="admin_todo.php">
            <div id="frame_op">
                <div id="block">
                    Wykonaj zamówienia.
                </div>
            </div>
        </a>
        <div id="right_frame_op"></div>
        <div id="header">
            <a id="appetizer">Przystawki:</a>
        </div>
        <div id="padding">
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
                $result = $connected->query("SELECT name, price, picture FROM products WHERE category='przystawka'");
                if (!$result) throw new Exception($connected->error);
                $how_many = $result->num_rows;
                $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                for($i=0; $i<$how_many; $i++)
                {
                    echo
                    '
                        <div id="left_frame"></div>
                        <div id="frame">
                            <a href="admin_edit.php?product_number=';
                    echo($i);
                    echo' &category_name=przystawka">
                            <div id="block">
                                    <img id="image" src=
                                    ';

                    print($product[$i]["picture"]);
                    echo
                    '      
                                     alt="" width="200" height="200">
                                <div id="description">
                                <br/><br/>
                                    <div id="description_name">
                                        ';
                    print($product[$i]["name"]);
                    echo'
                                    </div>
                                    <br/>
                                    <div id="description_price">
                                        ';
                    print($product[$i]["price"]);
                    echo
                    'zł
                                    </div>
                                    <div id="description_edit">
                                        <br/><br/>EDYTUJ!!!
                                    </div>
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
        <div id="header">
            <a id="steaks">Steki:</a>
        </div>
        <div id="padding">
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
                $result = $connected->query("SELECT name, price, picture FROM products WHERE category='stek'");
                if (!$result) throw new Exception($connected->error);
                $how_many = $result->num_rows;
                $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                for($i=0; $i<$how_many; $i++)
                {
                    echo
                    '
                        <div id="left_frame"></div>
                        <div id="frame">
                            <a href="admin_edit.php?product_number=';
                    echo($i);
                    echo' &category_name=stek">
                            <div id="block">
                                    <img id="image" src=
                                    ';
                    print($product[$i]["picture"]);
                    echo
                    '      
                                     alt="" width="200" height="200">
                                <div id="description">
                                <br/><br/>
                                    <div id="description_name">
                                        ';

                    print($product[$i]["name"]);
                    echo'
                                    </div>
                                    <br/>
                                    <div id="description_price">
                                        ';
                    print($product[$i]["price"]);
                    echo
                    'zł
                                    </div>
                                    <div id="description_edit">
                                        <br/><br/>EDYTUJ!!!
                                    </div>
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

        <div id="header">
            <a id="wine">Wino:</a>
        </div>
        <div id="padding">
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
                $result = $connected->query("SELECT name, price, picture FROM products WHERE category='wino'");
                if (!$result) throw new Exception($connected->error);
                $how_many = $result->num_rows;
                $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                for($i=0; $i<$how_many; $i++)
                {
                    echo
                    '
                        <div id="left_frame"></div>
                        <div id="frame">
                            <a href="admin_edit.php?product_number=';
                    echo($i);
                    echo' &category_name=wino">
                            <div id="block">
                                    <img id="image" src=
                                    ';
                    print($product[$i]["picture"]);
                    echo
                    '      
                                     alt="" width="200" height="200">
                                <div id="description">
                                <br/><br/>
                                    <div id="description_name">
                                        ';

                    print($product[$i]["name"]);
                    echo'
                                    </div>
                                    <br/>
                                    <div id="description_price">
                                        ';
                    print($product[$i]["price"]);
                    echo
                    'zł
                                    </div>
                                    <div id="description_edit">
                                        <br/><br/>EDYTUJ!!!
                                    </div>
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
    </div>

</div>

</body>
</html>