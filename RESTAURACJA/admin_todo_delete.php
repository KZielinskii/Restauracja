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
                $result = $connected->query("SELECT * FROM todo inner join products on todo.ProductID=products.ProductID inner join users on todo.LoginID=users.ID");
                if (!$result) throw new Exception($connected->error);
                $how_many = $result->num_rows;
                $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                $i = $_GET['nr'];
                $loginID = $product[$i]['LoginID'];

                if($connected->query("DELETE FROM `todo` WHERE `todo`.`LoginID` = '$loginID';"))
                {
                    $_SESSION['successfuladding']=true;
                    header('Location: admin_todo.php');
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