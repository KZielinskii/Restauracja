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

        $ProductID = $_SESSION['ProductID'];

        try
        {
            $connected = new mysqli($host, $db_user, $db_password, $db_name);
            if($connected->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {


                if($connected->query("DELETE FROM `products` WHERE `products`.`ProductID` = '$ProductID';"))
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