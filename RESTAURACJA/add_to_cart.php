<?php
    session_start();

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

                $result = $connected->query("SELECT `ProductID` FROM `products` WHERE `category`='$what_category'");
                if (!$result) throw new Exception($connected->error);
                $how_many = $result->num_rows;
                $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                $productID = 0;
                for($i=0; $i<$how_many; $i++)
                {
                    if($i == $product_number)
                    {
                        $productID = $product[$i]['ProductID'];
                    }
                }
                $result = $connected->query("SELECT * FROM `cart` WHERE `cart`.`LoginID`='$id' and `cart`.`ProductID`='$productID'");
                if(!$result)throw new Exception($connected->error);
                $how_many = $result->num_rows;
                $cart = mysqli_fetch_all($result,MYSQLI_ASSOC);
                if($how_many>0)
                {
                    $quantity = $cart[0]['quantity'];
                    $quantity += 1;
                    $_SESSION['cart_capacity'] += 1;
                    if($connected->query("UPDATE `cart` SET `quantity` ='$quantity' WHERE `cart`.`ProductID` ='$productID' and LoginID='$id'"))
                    {
                        $_SESSION['successfuladding']=true;
                        header('Location: menu.php');
                    }
                    else
                    {
                        throw new Exception($connected->error);
                    }
                    $connected->close();
                }
                else
                {
                    $_SESSION['cart_capacity'] += 1;
                    if($connected->query("INSERT INTO `cart` (`KoszykID`, `LoginID`, `ProductID`, `quantity`) VALUES (NULL, '$id', '$productID', '1');"))
                    {
                        $_SESSION['successfuladding']=true;
                        header('Location: menu.php');
                    }
                    else
                    {
                        throw new Exception($connected->error);
                    }
                    $connected->close();
                }
            }
        }catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Koszyk nieodpowiada! :( </span>';
            echo '<br/>Informacja developerska: '.$e;
        }

?>

