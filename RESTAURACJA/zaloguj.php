<?php

    session_start();

    if((!isset($_POST['login']))||(!isset($_POST['haslo'])))
    {
        header('Location: index.php');
        exit();
    }
    require_once "connect.php";
    $connected = @new mysqli($host, $db_user, $db_password, $db_name);

    if($connected->connect_errno!=0)
    {
        echo "Error: ".$connected->connect_errno;
    }
    else
    {
        $login = $_POST['login'];
        $password = $_POST['haslo'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        /* Cross Site Scripting */
        $login = htmlspecialchars($login);

        /* Ochrona przed wstrzykiwaniem sql w if*/
        if($rezultat = @$connected->query(sprintf("SELECT * FROM users WHERE login='%s'",
        mysqli_real_escape_string($connected,$login))))
        {
            $ilu_userow = $rezultat->num_rows;
            if($ilu_userow>0)
            {
                $row = $rezultat->fetch_assoc();
                if(password_verify($password, $row['password']))
                {
                    $_SESSION['zalogowany']=true;

                    $_SESSION['id'] = $row['ID'];
                    $_SESSION['login'] = $row['login'];

                    #Liczenie zawartości koszyka
                    $loginId = $_SESSION['id'];
                    $result = $connected->query("SELECT * FROM cart WHERE `cart`.`LoginID` = '$loginId'");
                    if (!$result) throw new Exception($connected->error);
                    $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
                    $how_many = $result->num_rows;
                    $capacity = 0;
                    for($i=0; $i<$how_many; $i++)
                    {
                        $capacity += $product[$i]['quantity'];
                    }

                    $_SESSION['cart_capacity'] = $capacity;

                    unset($_SESSION['error']);
                    $rezultat->close();
                    header('Location: menu.php');
                }
                else
                {
                    $_SESSION['error'] = '<span>Nieprawidłowy login lub hasło!</span>';
                    header('Location: index.php');
                }

            }else
            {
                $_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                header('Location: index.php');
            }
        }

        $connected->close();
    }

?>