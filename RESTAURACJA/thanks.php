<?php
session_start();

    if(!isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
        exit();
    }

    $paid = $_GET['what'];

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
        for($i=0; $i<$how_many; $i++)
        {
            $koszykID = $product[$i]["KoszykID"];
            $loginID = $product[$i]["LoginID"];
            $productID = $product[$i]["ProductID"];
            $quantity = $product[$i]["quantity"];


            if($connected->query("INSERT INTO todo VALUES (NULL,'$koszykID','$loginID','$productID','$quantity','$paid')"))
            {
                $_SESSION['successfuladding']=true;
            }
            else
            {
                throw new Exception($connected->error);
            }
        }

        if($connected->query("DELETE FROM cart WHERE cart.LoginID = '$loginId' "))
        {
            $_SESSION['successfuladding']=true;
            $_SESSION['cart_capacity'] = 0;
        }
        else
        {
            throw new Exception($connected->error);
        }
        $connected->close();
    }

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<link rel="stylesheet" href="style.css" type="text/css" />
    <title>Restauracja WinoStek - zamów jedzenie z dowozem do domu!</title>
</head>

<div id="top"></div>
<div id="left_frame_rand"></div>
<div id="frame_thx">
    <br/>
    <div id="block">
        <div id="thx">DZIĘKUJEMY ZA ZAKUP!!!</div>
    </div>
    <br/>
</div>
<div id="right_frame_rand"></div>
<div id="left_frame_op"></div>
<br/><br/>
<a href="menu.php">
    <div id="frame_op">
        <div id="block">
            Wróć do menu :)
        </div>
    </div>
</a>
<div id="clear"></div>




</body>
</html>