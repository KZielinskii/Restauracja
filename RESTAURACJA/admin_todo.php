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
                <a id="appetizer">Zamówienia:</a>
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
                    $prom = $_SESSION['prom'];
                    $result = $connected->query("SELECT * FROM todo inner join products on todo.ProductID=products.ProductID inner join users on todo.LoginID=users.ID");
                    if (!$result) throw new Exception($connected->error);
                    $how_many = $result->num_rows;
                    $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                    if($how_many==0)
                    {
                        echo'
                            <div id="left_frame"></div>
                            <div id="frame_form">
                                <br/>
                                <div id="block">
                                <MARQUEE behavior=alternate>Nie ma żadnych zamówień.</MARQUEE>
                                </div>
                                <br/>
                            </div>    
                            <div id="right_frame"></div><div>
                        ';
                    }
                    else
                    {
                    for($i=0; $i<$how_many; $i++)
                    {
                        if(!isset($_POST[$product[$i]["LoginID"]]))
                        {
                            if($i!=0)
                            {
                            echo'
                                <div id="left_frame_op"></div>
                                    <a href="admin_todo_delete.php?nr='; print($i-1); echo'">
                                        <div  id="frame_op">
                                            <div id="block">
                                            Wyślij zamówienie.
                                            </div>
                                        </div>
                                    </a>
                                <div id="right_frame"></div>
                                '; } echo'
                            </div>
                            <br/>
                            <div id="next_order">
                            <div id="description_name">
                                Następne zamówienie:
                            </div><br/>
                            <div>
                                Odbiorca: ';
                            print($product[$i]["name"]." ".$product[$i]["surename"]);
                            echo'
                            </div><br/>
                            <div>
                                E-mail: ';
                            print($product[$i]["email"]);
                            echo'
                            </div><br/>
                            <div>
                                Tel: ';
                            print($product[$i]["telephone"]);
                            echo'
                            </div><br/>
                            <div>
                                Wyślij na adres: ';
                                print($product[$i]["city"]." ul.".$product[$i]["street"]." ".$product[$i]["building"]."/".$product[$i]["apartament"]);
                            echo'
                            </div><br/>
                            ';
                            $_POST[$product[$i]["LoginID"]] = true;
                        }
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
                            print($product[$i]["name"]);
                            echo '
                                    </div>
                                
                                    <div id="description_cart_quantity_number">
                            ';
                            print("x".$product[$i]["quantity"]);
                            echo
                            '
                                    </div>
                                    <div id="description_cart">
                                        Zrobione:
                                    </div>
                                    <div id="description_cart_quantity_number">
                                        <input type="checkbox" id="xv" name="';
                        print($i);
                        echo
                        '" value="';
                        print($i);
                        echo
                        '">
                                    </div>
                                </div>
                            </div>
                            <div id="right_frame"></div>
                                ';
                    }
                    mysqli_free_result($result);
                    $connected->close();
                ?>
                <div id="left_frame_op"></div>
                <a href="admin_todo_delete.php?nr=<?php print($how_many-1) ?>">
                    <div  id="frame_op">
                        <div id="block">
                        Wyślij zamówienie.
                        </div>
                    </div>
                </a>
                <div id="right_frame"></div>
                </div>
                <br/>
            <?php }} ?>
            </div>
            <div id="right_min"></div>
        </div>
    </div>

</body>
</html>