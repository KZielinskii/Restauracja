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

        <div id="top"></div>
        <div id="left_min"></div>
        <div id="center_menu">
            <div id="header">
                <a id="appetizer">Twój koszyk:</a>
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
                    $loginId = $_SESSION['id'];
                    $prom = $_SESSION['prom'];
                    $result = $connected->query("SELECT * FROM cart inner join products on cart.ProductID=products.ProductID WHERE cart.LoginID = '$loginId' ");
                    if (!$result) throw new Exception($connected->error);
                    $how_many = $result->num_rows;
                    $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                    $all_price = 0;
                    if($how_many==0)
                    {
                        echo'
                            <div id="left_frame"></div>
                            <div id="frame_form">
                                <br/>
                                <div id="block">
                                <MARQUEE behavior=alternate>Twój koszyk jest pusty.</MARQUEE>
                                </div>
                                <br/>
                            </div>    
                            <div id="right_frame"></div>
                        ';
                    }
                    for($i=0; $i<$how_many; $i++)
                    {
                        if($prom == $product[$i]["ProductID"])
                        {
                            echo
                            '
                            <div id="left_frame"></div>
                            <div id="frame_form">
                                <div id="block">
                                        <img id="image" src=
                                        ';
                            print($product[$i]["picture"]);
                            echo
                            '      
                                         alt="" width="100" height="100">
                                    <div id="description_cart">
                                            ';
                            $price_for_products = round($product[$i]["price"]-($product[$i]["price"]/10),2) * $product[$i]["quantity"];
                            $all_price = $all_price + $price_for_products;
                            print($product[$i]["name"]);
                            echo '
                                    </div>
                                    <div id="description_cart">
                                        <div id="description_price_red_down">
                            ';
                            echo("(");
                            print(round($product[$i]["price"]-($product[$i]["price"]/10),2));
                            echo("zł/szt.)");
                            echo '
                                        </div>
                                        <div id="description_price_up">
                            ';
                            print($price_for_products);
                            echo("zł");
                            echo '
                                        </div>
                                    </div>
                                <a href="cart_sub_quantity.php?product_number=';
                            echo($i);
                            echo '">
                                    <div id="description_cart_quantity">
                                    <div id="shop_cart">
                                     <img src="graphic/sub.png" alt="" width="20" height="20">
                                    </div>
                                    </div>
                                </a>
                                    <div id="description_cart_quantity_number">
                            ';
                            print($product[$i]["quantity"]);
                            echo
                            '
                                    </div>
                                <a href="cart_add_quantity.php?product_number=';
                            echo($i);
                            echo '">
                                    <div id="description_cart_quantity">
                                    <div id="shop_cart">
                                    <img src="graphic/add.png" alt="" width="20" height="20">
                                    </div>
                                    </div>
                                </a>
                                <a href="cart_delete.php?product_number=';
                            echo($i);
                            echo '">
                                    <div id="description_cart_price">
                                        <div id="shop_cart">
                                        <img src="graphic/Waste-Basket.png" alt="" width="50" height="50">
                                        </div>
                                    </div>
                                </a>
                                </div>
                            </div>
                            <div id="right_frame"></div>
                                ';
                        }
                        else
                        {
                            echo
                            '
                            <div id="left_frame"></div>
                            <div id="frame_form">
                                <div id="block">
                                        <img id="image" src=
                                        ';
                            print($product[$i]["picture"]);
                            echo
                            '      
                                         alt="" width="100" height="100">
                                    <div id="description_cart">
                                            ';
                            $price_for_products = $product[$i]["price"] * $product[$i]["quantity"];
                            $all_price = $all_price + $price_for_products;
                            print($product[$i]["name"]);
                            echo '
                                    </div>
                                    <div id="description_cart">
                                        <div id="description_price_down">
                            ';
                            echo("(");
                            print($product[$i]["price"]);
                            echo("zł/szt.)");
                            echo '
                                        </div>
                                        <div id="description_price_up">
                            ';
                            print($price_for_products);
                            echo("zł");
                            echo '
                                        </div>
                                    </div>
                                <a href="cart_sub_quantity.php?product_number=';
                            echo($i);
                            echo '">
                                    <div id="description_cart_quantity">
                                    <div id="shop_cart">
                                     <img src="graphic/sub.png" alt="" width="20" height="20">
                                    </div>
                                    </div>
                                </a>
                                    <div id="description_cart_quantity_number">
                            ';
                            print($product[$i]["quantity"]);
                            echo
                            '
                                    </div>
                                <a href="cart_add_quantity.php?product_number=';
                            echo($i);
                            echo '">
                                    <div id="description_cart_quantity">
                                    <div id="shop_cart">
                                    <img src="graphic/add.png" alt="" width="20" height="20">
                                    </div>
                                    </div>
                                </a>
                                <a href="cart_delete.php?product_number=';
                            echo($i);
                            echo '">
                                    <div id="description_cart_price">
                                        <div id="shop_cart">
                                        <img src="graphic/Waste-Basket.png" alt="" width="50" height="50">
                                        </div>
                                    </div>
                                </a>
                                </div>
                            </div>
                            <div id="right_frame"></div>
                                ';
                        }
                    }
                    mysqli_free_result($result);
                    $connected->close();
                }
                ?>
            </div>
                <div id="left_frame"></div>
                <div id="frame_form">
                    <br/>
                    <div id="block">
                    Wartość do zapłaty:
                    <?php
                    print("$all_price");
                    ?>
                    zł.
                    </div>
                    <br/>
                </div>

                <div id="right_frame"></div>
            <?php
            if($all_price != 0)
            {
                echo '
                <form action="thanks.php">
                <div id="left_frame"></div>
                <div id="frame_form">
                    <br/>
                    <div id="block">
                      <label for="what">Wybierz płatność:</label>
                      <select id="what" name="what">
                        <option value="blik">BLIK</option>
                        <option value="payu">PayU</option>
                        <option value="paypal">PayPal</option>
                        <option value="przelewy24">Przelewy24</option>
                      </select>
                    </div>
                    <br/>
                </div>

                <div id="right_frame"></div>
                
                <div id="left_frame_op"></div>
                        <input id="frame_op" type="submit" value="Zapłać">
                <div id="right_frame"></div>
                
                </form>
                ';
            }
            ?>
            <div id="right_min"></div>
        </div>
    </div>

</body>
</html>