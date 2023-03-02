<?php
    session_start();

    if(!isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
        exit();
    }

    $id = $_SESSION['id'];
    $id_to_del = $_GET['id_to_del'];

    echo($id_to_del);

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
                if ($connected->query("DELETE FROM `opinions` WHERE OpinionID = '$id_to_del'")) {
                    $_SESSION['successfuladding'] = true;
                    header('Location: opinie.php');
                } else {
                    throw new Exception($connected->error);
                }
                $connected->close();
            }
        }catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Rejestracja niemożliwa! :( </span>';
            echo '<br/>Informacja developerska: '.$e;
        }


?>