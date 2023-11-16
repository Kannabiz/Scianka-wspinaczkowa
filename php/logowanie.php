<?php
    session_start();
    echo "<script>localStorage.setItem('wyswietlany', '1');</script>";

    if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true)
    {
        header ('Location: panel.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STREFA WOLNOŚCI - Logowanie</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/logowanieStyle.css">
</head>
<body>
    <?php
        require_once 'menu.php';
    ?>

    <div id="logContainer">
        <h2>Zaloguj się</h2>
        <div id="panelLogowania">
            <form action="weryfikator.php" method="post">

                <label for="email">E-mail</label><br>
                <input type="email" name="email" id="email"><br>
                
                <label for="haslo">Hasło</label><br>
                <input type="password" name="haslo" id="haslo"><br>

                <input type="submit" value="Zaloguj się"><br>

            </form>
        <?php

            if(isset($_SESSION['blad']))
            {
                echo $_SESSION['blad'];
                unset($_SESSION['blad']);
            }

        ?>
        </div>
    </div>
    <script src="../js/menu.js"></script>
</body>
</html>