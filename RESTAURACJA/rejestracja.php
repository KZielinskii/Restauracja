<?php
    session_start();

    if (isset($_POST['login']))
    {
        $OK=true;

        $login = $_POST['login'];
        if((strlen($login)<5) || (strlen($login)>15))
        {
            $OK=false;
            $_SESSION['e_login']="Login musi posiadać od 5 do 15 znaków!";
        }
        if(ctype_alnum($login)==false)
        {
            $OK=false;
            $_SESSION['e_login']="Login może składać się tylko z liter i cyfr (bez polskich znaków)!";
        }

        $name = $_POST['name'];
        if(strlen($name)<1)
        {
            $OK=false;
            $_SESSION['e_name']="Wprowadź imię!";
        }

        $surename = $_POST['surename'];
        if(strlen($surename)<1)
        {
            $OK=false;
            $_SESSION['e_surename']="Wprowadź nazwisko!";
        }

        $telephone = $_POST['telephone'];
        if(!is_numeric($telephone))
        {
            $OK=false;
            $_SESSION['e_telephone']="Wprowadź cyfry!";
        }
        if(strlen($telephone)!=9)
        {
            $OK=false;
            $_SESSION['e_telephone']="Telefon powinien mieć 9 cyfr!";
        }

        $city = $_POST['city'];
        if(strlen($surename)<1)
        {
            $OK=false;
            $_SESSION['e_city']="Wprowadź poprawne misto!";
        }

        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false)||($emailB!=$email))
        {
            $OK=false;
            $_SESSION['e_email']="Wprowadź poprawny adres e-mail!";
        }

        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if((strlen($password1)<8) || (strlen($password1)>20))
        {
            $OK=false;
            $_SESSION['e_password']="Hasło musi zawierać od 8 do 20 znaków!";
        }
        if($password1!=$password2)
        {
            $OK=false;
            $_SESSION['e_password']="Hasła nie są identyczne!";
        }

        $password_hash = password_hash($password1,PASSWORD_DEFAULT);

        if(!isset($_POST['statute']))
        {
            $OK=false;
            $_SESSION['e_statute']="Przeczytaj i zaznacz regulamin!";
        }
        $street =  $_POST['street'];
        $buildingnumer =  $_POST['buildingnumer'];
        $apartamentnumber =  $_POST['apartamentnumber'];

    if(isset($_SESSION['fr_login']))unset($_SESSION['fr_login']);
    if(isset($_SESSION['fr_name']))unset($_SESSION['fr_name']);
    if(isset($_SESSION['fr_surename']))unset($_SESSION['fr_surename']);
    if(isset($_SESSION['fr_telephone']))unset($_SESSION['fr_telephone']);
    if(isset($_SESSION['fr_city']))unset($_SESSION['fr_city']);
    if(isset($_SESSION['fr_email']))unset($_SESSION['fr_email']);
    if(isset($_SESSION['fr_password1']))unset($_SESSION['fr_password1']);
    if(isset($_SESSION['fr_password2']))unset($_SESSION['fr_password2']);
    if(isset($_SESSION['fr_street']))unset($_SESSION['fr_street']);
    if(isset($_SESSION['fr_buildingnumer']))unset($_SESSION['fr_buildingnumer']);
    if(isset($_SESSION['fr_apartamentnumber']))unset($_SESSION['fr_apartamentnumber']);
    if(isset($_SESSION['fr_statute']))unset($_SESSION['fr_statute']);

        //Zapamiętaj dane
        $_SESSION['fr_login'] = $login;
        $_SESSION['fr_name'] = $name;
        $_SESSION['fr_surename'] = $surename;
        $_SESSION['fr_telephone'] = $telephone;
        $_SESSION['fr_city'] = $city;
        $_SESSION['fr_email'] = $email;
        $_SESSION['fr_password1'] = $password1;
        $_SESSION['fr_password2'] = $password2;
        $_SESSION['fr_street'] = $street;
        $_SESSION['fr_buildingnumer'] = $buildingnumer;
        $_SESSION['fr_apartamentnumber'] = $apartamentnumber;
        if(isset($_POST['statute']))$_SESSION['fr_statute']=true;


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
                //email już istnieje?
                $result = $connected->query("SELECT id FROM users WHERE email='$email'");
                if(!$result)throw new Exception($connected->error);

                $how_many = $result->num_rows;
                if($how_many>0)
                {
                    $OK=false;
                    $_SESSION['e_email']="Istnieje już konto o tym adresie e-mail!";
                }
                //login już istnieje?
                $result = $connected->query("SELECT id FROM users WHERE login='$login'");
                if(!$result)throw new Exception($connected->error);

                $how_many = $result->num_rows;
                if($how_many>0)
                {
                    $OK=false;
                    $_SESSION['e_login']="Istnieje już konto o tym loginie!";
                }

                if($OK==true)
                {
                    if($connected->query("INSERT INTO users VALUES (NULL,'$login','$name','$surename','$telephone','$city','$email','$password_hash','$street','$buildingnumer','$apartamentnumber')"))
                    {
                        $_SESSION['successfuladding']=true;
                        header('Location: witamy.php');
                    }
                    else
                    {
                        throw new Exception($connected->error);
                    }
                }
                $connected->close();
            }
        }catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Rejestracja niemożliwa! :( </span>';
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
    <title>Restauracja - załóż darmowe konto!</title>
    <style>
        .error
        {
            font-size: 10px;
            color:red;
        }
    </style>
</head>
<body>
        <div class="menu">
            <div class="dropdown">
                <a href="http://localhost/RESTAURACJA/menu.php">Menu</a>
                <ul>
                    <li><a href="menu.php">Przystawki</a></li>
                    <li><a href="menu.php">Steki</a></li>
                    <li><a href="menu.php">Wino</a></li>
                </ul>
                <a href="opinie.php">Opinie</a>
                <a href="kontakt.php">Kontakt</a>
            </div>
            <a id="a_register" href="rejestracja.php">Zarejestruj się!</a>
        </div>
        <div id="logo">
            <a href="http://localhost/RESTAURACJA/index.php"><img src="graphic/logo.png" alt="Logo - WinoStek" width="200" height="100"></a>
        </div>
    <div id="left"></div>
    <div id="center">
        <div id="top"></div>
            <form id="formularz" method="post">

                Login: </br><input type="text" value="<?php
                    if(isset($_SESSION['fr_login']))
                    {
                        echo $_SESSION['fr_login'];
                        unset($_SESSION['fr_login']);
                    }
                ?>"
                name="login"/></br>
                <?php
                    if(isset($_SESSION['e_login']))
                    {
                        echo'<div class="error">'.$_SESSION['e_login'].'</div>';
                        unset($_SESSION['e_login']);
                    }
                ?>

                Hasło: </br><input type="password" value="<?php
                    if(isset($_SESSION['fr_password1']))
                    {
                        echo $_SESSION['fr_password1'];
                        unset($_SESSION['fr_password1']);
                    }
                    else
                    {

                    }
                ?>"
                name="password1"/></br>
                <?php
                    if(isset($_SESSION['e_password']))
                    {
                        echo'<div class="error">'.$_SESSION['e_password'].'</div>';
                        unset($_SESSION['e_password']);
                    }
                ?>

                Powtórz hasło: </br><input type="password" value="<?php
                    if(isset($_SESSION['fr_password2']))
                    {
                        echo $_SESSION['fr_password2'];
                        unset($_SESSION['fr_password2']);
                    }
                ?>"
                name="password2"/></br>

                Imię: </br><input type="text" value="<?php
                    if(isset($_SESSION['fr_name']))
                    {
                        echo $_SESSION['fr_name'];
                        unset($_SESSION['fr_name']);
                    }
                ?>"
                name="name"/></br>
                <?php
                    if(isset($_SESSION['e_name']))
                    {
                        echo'<div class="error">'.$_SESSION['e_name'].'</div>';
                        unset($_SESSION['e_name']);
                    }
                ?>

                Nazwisko: </br><input type="text" value="<?php
                    if(isset($_SESSION['fr_surename']))
                    {
                        echo $_SESSION['fr_surename'];
                        unset($_SESSION['fr_surename']);
                    }
                ?>"
                name="surename"/></br>
                <?php
                    if(isset($_SESSION['e_surename']))
                    {
                        echo'<div class="error">'.$_SESSION['e_surename'].'</div>';
                        unset($_SESSION['e_surename']);
                    }
                ?>

                E-mail: </br><input type="text" value="<?php
                    if(isset($_SESSION['fr_email']))
                    {
                        echo $_SESSION['fr_email'];
                        unset($_SESSION['fr_email']);
                    }
                ?>"
                name="email"/></br>
                <?php
                    if(isset($_SESSION['e_email']))
                    {
                        echo'<div class="error">'.$_SESSION['e_email'].'</div>';
                        unset($_SESSION['e_email']);
                    }
                ?>

                Telefon: </br><input type="text" value="<?php
                    if(isset($_SESSION['fr_telephone']))
                    {
                        echo $_SESSION['fr_telephone'];
                        unset($_SESSION['fr_telephone']);
                    }
                ?>"
                name="telephone"/></br>
                <?php
                    if(isset($_SESSION['e_telephone']))
                    {
                        echo'<div class="error">'.$_SESSION['e_telephone'].'</div>';
                        unset($_SESSION['e_telephone']);
                    }
                ?>

                Miasto: </br><input type="text" value="<?php
                    if(isset($_SESSION['fr_city']))
                    {
                        echo $_SESSION['fr_city'];
                        unset($_SESSION['fr_city']);
                    }
                ?>"
                name="city"/></br>
                <?php
                    if(isset($_SESSION['e_city']))
                    {
                        echo'<div class="error">'.$_SESSION['e_city'].'</div>';
                        unset($_SESSION['e_city']);
                    }
                ?>

                Ulica: </br><input type="text" value="<?php
                    if(isset($_SESSION['fr_street']))
                    {
                        echo $_SESSION['fr_street'];
                        unset($_SESSION['fr_street']);
                    }
                ?>"
                name="street"/></br>
                Numer budynku: </br><input type="text" value="<?php
                    if(isset($_SESSION['fr_buildingnumer']))
                    {
                        echo $_SESSION['fr_buildingnumer'];
                        unset($_SESSION['fr_buildingnumer']);
                    }
                ?>"
                name="buildingnumer"/></br>
                Numer mieszkania: </br><input type="text" value="<?php
                    if(isset($_SESSION['fr_apartamentnumber']))
                    {
                        echo $_SESSION['fr_apartamentnumber'];
                        unset($_SESSION['fr_apartamentnumber']);
                    }
                ?>"
                name="apartamentnumber"/></br>

                <label>
                    <input type="checkbox" name="statute" <?php
                    if(isset($_SESSION['fr_statute']))
                    {
                        echo "checked";
                        unset($_SESSION['fr_statute']);
                    }
                    ?>/> Akceptuję
                </label>
                <a href="regulamin.php" target="_blank">regulamin</a></br>
                <?php
                    if(isset($_SESSION['e_statute']))
                    {
                        echo'<div class="error">'.$_SESSION['e_statute'].'</div>';
                        unset($_SESSION['e_statute']);
                    }
                ?>
                <br />
                <input type="submit" id="button_login" value="Zarejestruj się"/>

            </form>
        </div>
    <div id="right"></div>
    <div id="footer"></div>

</body>
</html>