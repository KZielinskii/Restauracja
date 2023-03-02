<?php
    session_start();

    if(!isset($_SESSION['zalogowany']))
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
                $loginId = $_SESSION['id'];
                $number_product = $_GET['product_number'];
                $result = $connected->query("SELECT * FROM cart inner join products on cart.ProductID=products.ProductID WHERE cart.LoginID = '$loginId'");
                if (!$result) throw new Exception($connected->error);
                $how_many = $result->num_rows;
                $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                $all_price = 0;
                $productID = 0;
                for($i=0; $i<$how_many; $i++)
                {
                    if($i == $number_product)
                    {
                        $productID = $product[$i]["ProductID"];
                        $new_quantity = $product[$i]["quantity"];
                    }
                }
                $new_quantity -= 1;
                $_SESSION['cart_capacity'] -= 1;
                if($new_quantity == 0)
                {
                    if($connected->query("DELETE FROM `cart` WHERE `cart`.`LoginID` = '$loginId' and `cart`.`ProductID` = '$productID';"))
                    {
                        $_SESSION['successfuladding']=true;
                        header('Location: cart.php');
                    }
                    else
                    {
                        throw new Exception($connected->error);
                    }
                }

                if($connected->query("UPDATE `cart` SET `quantity` = '$new_quantity' WHERE `cart`.`LoginID` = '$loginId' and `cart`.`ProductID` = '$productID'"))
                {
                    $_SESSION['successfuladding']=true;
                    header('Location: cart.php');
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