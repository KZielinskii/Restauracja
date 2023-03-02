<?php
    session_start();

    if(!isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
        exit();
    }

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
        $product = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if(!isset($_SESSION['is_rand']))
        {
            $rand_number = rand(0, $how_many - 1);
            $_SESSION['is_rand']=$rand_number;
        }
        else
        {
            $rand_number =  $_SESSION['is_rand'];
        }
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
                        $many = $result->num_rows;
                    }

                    echo '<a href="admin_todo.php" class="notification2"> 
                        <span>Zamówienia </span>
                        <span class="badge2">
                                ';
                    echo($many);
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
            <div>
                <div id="left_frame_rand"></div>
                <div id="frame_prom">Promocja!!!</div>
                <div id="right_frame_rand"></div>
                <div id="left_frame_rand"></div>
                <div id="frame_rand">
                    <a href="add_to_cart.php?product_number=<?php echo($rand_number) ?>&category_name=stek">
                        <div id="block">
                            <img id="image_prom" src=<?php echo($product[$rand_number]['picture']) ?> alt="" width="200" height="200">
                            <div id="description">
                                <br/>
                                <div id="description_name">
                                    <?php echo($product[$rand_number]["name"]) ?>
                                </div>
                                <br/>
                                <div id="description_price">
                                    <s><?php echo($product[$rand_number]["price"]) ?>zł</s>
                                </div>
                                <div id="description_price_red">
                                    <?php
                                    $price = $product[$rand_number]["price"];
                                    $price = round($price - ($price/10),2);
                                    echo($price) ?>zł
                                </div>
                                <div id="description_add_to_cart">
                                    <br/><br/>+ dodaj do koszyka
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="right_frame"></div>
            </div>
            <div id="left_min"></div>
            <div id="center_menu">
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
                            <a href="add_to_cart.php?product_number=';
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
                                    <div id="description_add_to_cart">
                                        <br/><br/>+ dodaj do koszyka
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
                        $result = $connected->query("SELECT * FROM products WHERE category='stek'");
                        if (!$result) throw new Exception($connected->error);
                        $how_many = $result->num_rows;
                        $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                        for($i=0; $i<$how_many; $i++)
                        {
                            echo
                            '
                        <div id="left_frame"></div>
                        <div id="frame">
                            <a href="add_to_cart.php?product_number=';
                            echo($i);
                            echo' &category_name=stek">
                            <div id="block">
                                    <img id="image" src=
                                    ';
                            print($product[$i]["picture"]);
                            echo
                            '      
                                     alt="" width="200" height="200">';
                            if($i == $rand_number)
                            {
                                $_SESSION['prom'] = $product[$i]["ProductID"];
                                echo'
                                <div id="description">
                                <br/>
                                    <div id="description_name">
                                        ';
                            print($product[$i]["name"]);
                            echo'
                                    </div>
                                    <br/>
                                    <div id="description_price">
                                        ';
                                echo'
                                <div id="description_price_s">
                                            <s>'; echo($product[$rand_number]["price"]); echo'zł</s>
                                </div>
                                <div id="description_price_red">
                                                ';
                                $price = $product[$rand_number]["price"];
                                $price = round($price - ($price/10),2);
                                echo($price); echo'zł
                                </div>
                                            ';
                            }
                            else
                            {
                                echo'
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
                                echo("zł");
                            }
                            echo
                            '
                                    </div>
                                    <div id="description_add_to_cart">
                                        <br/><br/>+dodaj do koszyka
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
                            <a href="add_to_cart.php?product_number=';
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
                                    <div id="description_add_to_cart">
                                        <br/><br/>+ dodaj do koszyka
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
            <div id="right_min"></div>
        </div>
    </div>
</body>
</html>