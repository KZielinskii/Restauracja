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

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $connected = new mysqli($host, $db_user, $db_password, $db_name);
            if($connected->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                $id =  $_SESSION['id'];
                $product_number = $_GET['product_number'];
                $what_category = $_GET['category_name'];

                $result = $connected->query("SELECT * FROM `products` WHERE `category`='$what_category'");
                if (!$result) throw new Exception($connected->error);
                $how_many = $result->num_rows;
                $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                $productID = 0;
                for($i=0; $i<$how_many; $i++)
                {
                    if($i == $product_number)
                    {
                        $productID = $product[$i]['ProductID'];
                        $productName = $product[$i]['name'];
                        $price = $product[$i]['price'];
                        $picture = $product[$i]['picture'];
                    }
                }
                $_SESSION['ProductID'] = $productID;
            }
        }catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Edycja danych niemożliwe! :( </span>';
            echo '<br/>Informacja developerska: '.$e;
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
        <div id="padding">
            <div id="left_frame"></div>
            <div id="frame_form">
            <div id="block">
                </br><br/>
                <form action="admin_activate_edit.php" method="post">
                    Wprowadź nazwe produktu: <br/><input type="text" value="<?php
                    echo("$productName");
                    ?>" name="name"/></br></br>
                    Wprowadź kategorie produktu: <br/><input type="text" value="<?php
                    echo("$what_category");
                    ?>" name="category"/></br></br>
                    Wprowadź cenę produktu: <br/><input type="text" value="<?php
                    echo("$price");
                    ?>" name="price"/></br></br>

                    <input type="file" id="button_file" value="<?php
                    echo("$picture");
                    ?>" name="picture">
                    <br/><br/>
                    <input type="submit" id="button_login" value="Edytuj produkt"/>
                </form>
                <br/><br/>
            </div>
            </div>
            <div id="right_frame"></div>
            <div id="left_frame"></div>
            <div id="frame_form">
                <a href="admin_delete.php">
                    <div id="block"><br/>
                    <div id="button_login">
                        Usuń produkt z menu.
                    </div>
                    </div><br/><br/>
                </a>
            </div>
            <div id="right_frame"></div>
        </div>

    </div>
    <div id="right_min"></div>

</div>

</body>
</html>