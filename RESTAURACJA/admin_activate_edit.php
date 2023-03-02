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
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $picture = "graphic/".$_POST['picture'];

    $productID = $_SESSION['ProductID'];

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

            if($connected->query("UPDATE `products` SET `category` = '$category', `price` = '$price', `name` = '$name', `picture` = '$picture' WHERE `products`.`ProductID` = '$productID'"))
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

?>
