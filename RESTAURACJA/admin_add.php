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

    if(isset($_POST['name']) )
    {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $picture = "graphic/".$_POST['picture'];

        /* Cross Site Scripting */
        $name = htmlspecialchars($name);
        $category = htmlspecialchars($category);
        $price = htmlspecialchars($price);
        $picture = htmlspecialchars($picture);

        if(isset($_SESSION['fr_name']))unset($_SESSION['fr_name']);
        if(isset($_SESSION['fr_category']))unset($_SESSION['fr_category']);
        if(isset($_SESSION['fr_price']))unset($_SESSION['fr_price']);
        if(isset($_SESSION['fr_picture']))unset($_SESSION['fr_picture']);

        $_SESSION['fr_name'] = $name;
        $_SESSION['fr_category'] = $category;
        $_SESSION['fr_price'] = $price;
        $_SESSION['fr_picture'] = $picture;

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

                if($connected->query("INSERT INTO products VALUES (NULL,'$category','$price','$name','$picture')"))
                {
                    $_SESSION['successfuladding']=true;
                    header('Location: admin.php');
                }
                else
                {
                    throw new Exception($connected->error);
                }
                $connected->close();
            }
        }catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Wprowadzenie danych niemożliwe! :( </span>';
            echo '<br/>Informacja developerska: '.$e;
        }

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
    <div id="left_frame"></div>
    <div id="center_menu">
        <div id="header">
            Panel administracyjny:
        </div>
        <br/><br/>
        <div id="left_frame"></div>
        <div id="frame_form">
            <div id="block">
                </br><br/>
                <form method="post">
                Wprowadź nazwe produktu: <br/><input type="text" value="<?php
                if(isset($_SESSION['fr_name']))
                {
                    echo $_SESSION['fr_name'];
                    unset($_SESSION['fr_name']);
                }
                ?>" name="name"/></br></br>
                Wprowadź kategorie produktu: <br/><input type="text" value="<?php
                if(isset($_SESSION['fr_category']))
                {
                    echo $_SESSION['fr_category'];
                    unset($_SESSION['fr_category']);
                }
                ?>" name="category"/></br></br>
                Wprowadź cenę produktu: <br/><input type="text" value="<?php
                if(isset($_SESSION['fr_price']))
                {
                    echo $_SESSION['fr_price'];
                    unset($_SESSION['fr_price']);
                }
                ?>" name="price"/></br></br>

                        <input type="file" id="button_file" value="<?php
                        if(isset($_SESSION['fr_picture']))
                        {
                            echo $_SESSION['fr_picture'];
                            unset($_SESSION['fr_picture']);
                        }
                        ?>" name="picture">
                </br></br>
                <input type="submit" id="button_login" value="Dodaj produkt"/>
                </form>
                <br/><br/>
            </div>
        </div>
    </div>
    <div id="right_frame"></div>
    </div>
    <div id="right_min"></div>

</div>

</body>
</html>