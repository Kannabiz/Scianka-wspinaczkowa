<?php
    session_start();

    if(!isset($_POST['email']) || !isset($_POST['haslo']))
    {
        header ('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>placeholder</title>
</head>
<body>
    <?php

    $id = new mysqli('localhost','root','','baza_sw');

    if($id -> connect_errno != 0)
    {
        echo "Error: ".$id->connect_errno;
    }
    else
    {
        $email = $_POST['email'];
        $haslo = $_POST['haslo'];
        
        $email = htmlentities($email, ENT_QUOTES, "UTF-8");

        if($rezultat = @$id -> query(
        sprintf("SELECT * FROM uzytkownik WHERE email='%s'",
        mysqli_real_escape_string($id, $email))));
        {
            $ileOsob = $rezultat -> num_rows;
            if($ileOsob > 0)
            {
                $wiersz = $rezultat -> fetch_assoc();

                if(password_verify($haslo, $wiersz['haslo']))
                {
                    $_SESSION['zalogowany'] = true;

                    $_SESSION['id'] = $wiersz['id'];
                    $_SESSION['imie'] = $wiersz['imie'];
                    $_SESSION['nazwisko'] = $wiersz['nazwisko'];
                    $_SESSION['telefon'] = $wiersz['telefon'];
                    $_SESSION['email'] = $wiersz['email'];
                    $_SESSION['admin'] = $wiersz['admin'];

                    unset($_SESSION['blad']);

                    $rezultat->close();

                    header('Location: panel.php');
                }
                else
                {
                    $_SESSION['blad'] = '<p id="error">Nieprawidłowy E-mail lub hasło</p>';
                    header('Location: logowanie.php');
                }
            }
            else
            {
                $_SESSION['blad'] = '<p id="error">Nieprawidłowy E-mail lub hasło</p>';
                header('Location: logowanie.php');
            }
        }

        $id->close();

    }

    
    

    ?>
</body>
</html>