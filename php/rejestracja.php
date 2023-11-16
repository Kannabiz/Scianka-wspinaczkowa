<?php
    session_start();

    mysqli_report(MYSQLI_REPORT_STRICT);

    if(isset($_POST['imie']))
    {

        $poprawnosc = true;

        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        $telefon = $_POST['telefon'];
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];


        //imie


        if(empty($imie))
        {
            $poprawnosc = false;
            $_SESSION['e_imie']="Imię nie jest ustawione";
        } 
        else if (preg_match('/^[\p{Latin}]+$/u', $imie) == false)
        {
            $poprawnosc = false;
            $_SESSION['e_imie']="Imię powinno składać się tylko z liter";
        }


        //nazwisko


        if(empty($nazwisko))
        {
            $poprawnosc = false;
            $_SESSION['e_nazwisko']="Nazwisko nie jest ustawione";
        }
        else if (preg_match('/^[\p{Latin}]+$/u', $nazwisko) == false)
        {
            $poprawnosc = false;
            $_SESSION['e_nazwisko']="Nazwisko powinno składać się tylko z liter";
        }


        //email


        if(($emailB != $email) || (filter_var($emailB, FILTER_VALIDATE_EMAIL) == false))
        {
            $poprawnosc = false;
            $_SESSION['e_email']="Podaj poprawny adres email";
        }


        //telefon

        if(!empty($_POST['telefon']) && ((strlen($telefon) != 9) || preg_match('/[0-9]{9}/', $telefon) == false))
        {
            $podanie_telefonu = true;
            $poprawnosc = false;
            $_SESSION['e_telefon']="Podaj poprawny numer telefonu";
        }

        if(empty($_POST['telefon']))
        {
            $telefon = NULL;
        }
        

        //hasło


        if(strlen($haslo1) < 8 || strlen($haslo1) > 20)
        {
            $poprawnosc = false;
            $_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków";
        }

        if($haslo1 != $haslo2)
        {
            $poprawnosc = false;
            $_SESSION['e_haslo']="Hasła muszą być takie same";
        }

        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);


        //reCaptcha


        $s_klucz = "6Lfob20lAAAAANELn9tMTPW4weuF3-WrBVmtu0qC";

        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$s_klucz.'&response='.$_POST['g-recaptcha-response']);
        $odpowiedz = json_decode($sprawdz);

        if($odpowiedz->success == false)
        {
            $poprawnosc = false;
            $_SESSION['e_bot']="Potwierdź, że jesteś człowiekiem";
        }

        //zapamiętywanie danych

        $_SESSION['fr_imie'] = $imie;
        $_SESSION['fr_nazwisko'] = $nazwisko;
        $_SESSION['fr_email'] = $email;
        $_SESSION['fr_telefon'] = $telefon;
        $_SESSION['fr_haslo1'] = $haslo1;
        $_SESSION['fr_haslo2'] = $haslo2;

        try
        {
        $id = mysqli_connect('localhost','root','','baza_sw');
        if($id -> connect_errno != 0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {

            //weryfikacja istnienia emaila


            $wynik = $id -> query("SELECT id FROM uzytkownik WHERE email = '$email'");

            if(!$wynik)
            {
                throw new Exception($id -> error);
            }

            $ile_duplikatow = $wynik -> num_rows;

            if($ile_duplikatow > 0)
            {
                $poprawnosc = false;
                $_SESSION['e_email']="Taki adres e-mail został już użyty!";
            }


            //weryfikacja istnienia numeru telefonu


            $wynik = $id -> query("SELECT id FROM uzytkownik WHERE telefon = '$telefon'");

            if(!empty($_POST['telefon']))
            {
                if(!$wynik)
                {
                    throw new Exception($id -> error);
                }
    
                $ile_duplikatow = $wynik -> num_rows;
    
                if($ile_duplikatow > 0)
                {
                    $poprawnosc = false;
                    $_SESSION['e_telefon']="Taki numer telefonu został już użyty!";
                }
            }
            else
            {

            }
            


            if($poprawnosc == true)
            {
                if(is_null($telefon))
                {
                    if($id -> query("INSERT INTO uzytkownik (imie,nazwisko,haslo,telefon,email) VALUES ('$imie', '$nazwisko', '$haslo_hash', NULL , '$email')"))
                    {
                        $_SESSION['udana_rejestracja'] = true;
                        header('Location: witamy.php');
                    }
                    else
                    {
                        throw new Exception($id->error);
                    }
                }
                else
                {
                    if($id -> query("INSERT INTO uzytkownik (imie,nazwisko,haslo,telefon,email) VALUES ('$imie', '$nazwisko', '$haslo_hash', '$telefon', '$email')"))
                    {
                        $_SESSION['udana_rejestracja'] = true;
                        header('Location: witamy.php');
                    }
                    else
                    {
                        throw new Exception($id->error);
                    }    
                }
            }

            mysqli_close($id);
        }
        }
        catch(Exception $e)
        {
            echo 'Błąd serwera! Przepraszamy za niedogodności';
            //echo 'Błąd: '.$e;
            exit();
        }

    }

?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STREFA WOLNOŚCI - Rejestracja</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="../css/rejestracjaStyle.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
    <?php
        require_once 'menu.php';
    ?>

    <div id="container">
        <div id="panelRejestracji">
            <form method="post">
                <table>
                    <tr><td><label for="imie">Imię:</label></td><td>
                        <input type="text" name="imie" id="imie" value="<?php
                        if(isset($_SESSION['fr_imie']))
                        {
                            echo $_SESSION['fr_imie'];
                            unset($_SESSION['fr_imie']);
                        }
                        ?>"><br>

                        <?php
                            if(isset($_SESSION['e_imie']))
                            {
                                echo "<p>".$_SESSION['e_imie']."</p>";
                                unset($_SESSION['e_imie']);
                            }
                        ?>
                    </td></tr>
                    <tr><td><label for="nazwisko">Nazwisko:</label></td><td>
                        <input type="text" name="nazwisko" id="nazwisko" value="<?php
                        if(isset($_SESSION['fr_nazwisko']))
                        {
                            echo $_SESSION['fr_nazwisko'];
                            unset($_SESSION['fr_nazwisko']);
                        }
                        ?>"><br>

                        <?php
                            if(isset($_SESSION['e_nazwisko']))
                            {
                                echo "<p>".$_SESSION['e_nazwisko']."</p>";
                                unset($_SESSION['e_nazwisko']);
                            }
                        ?>
                        </td></tr>
                        <tr><td><label for="email">E-mail:</label></td><td>
                            <input type="text" name="email" id="email" value="<?php
                            if(isset($_SESSION['fr_email']))
                            {
                                echo $_SESSION['fr_email'];
                                unset($_SESSION['fr_email']);
                            }
                            ?>"><br>

                            <?php
                                if(isset($_SESSION['e_email']))
                                {
                                    echo "<p>".$_SESSION['e_email']."</p>";
                                    unset($_SESSION['e_email']);
                                }
                            ?>
                        </td></tr>
                        <tr><td><label for="telefon">Numer telefonu (opcjonalne):</label></td><td>
                            <input type="text" name="telefon" id="telefon" value="<?php
                            if(isset($_SESSION['fr_telefon']))
                            {
                                echo $_SESSION['fr_telefon'];
                                unset($_SESSION['fr_telefon']);
                            }
                            ?>"><br>

                            <?php
                                if(isset($_SESSION['e_telefon']))
                                {
                                    echo "<p>".$_SESSION['e_telefon']."</p>";
                                    unset($_SESSION['e_telefon']);
                                }
                            ?>
                        </td></tr>
                        <tr><td><label for="haslo1">Hasło:</label></td><td>
                            <input type="password" name="haslo1" id="haslo1" value="<?php
                            if(isset($_SESSION['fr_haslo1']))
                            {
                                echo $_SESSION['fr_haslo1'];
                                unset($_SESSION['fr_haslo1']);
                            }
                            ?>"><br>

                            <?php
                                if(isset($_SESSION['e_haslo']))
                                {
                                    echo "<p>".$_SESSION['e_haslo']."</p>";
                                    unset($_SESSION['e_haslo']);
                                }
                            ?>
                        </td></tr>
                        <tr><td><label for="haslo2">Powtórz hasło:</label></td><td>
                            <input type="password" name="haslo2" id="haslo2" value="<?php
                            if(isset($_SESSION['fr_haslo2']))
                            {
                                echo $_SESSION['fr_haslo2'];
                                unset($_SESSION['fr_haslo2']);
                            }
                            ?>"><br>
                        </td></tr>
                        <tr><td colspan=2 rowspan=2>
                            <div id="reszta">
                                <div class="g-recaptcha" data-sitekey="6Lfob20lAAAAAH7QnD4ckyFGPC_OC3XNoabtcS2Q"></div>

                                <?php
                                    if(isset($_SESSION['e_bot']))
                                    {
                                        echo "<p>".$_SESSION['e_bot']."</p>";
                                        unset($_SESSION['e_bot']);
                                    }
                                ?>
                                <input type="submit" value="Zarejestruj się">
                            </div>
                            
                                
                        </td></tr>
                        </tr>
                </table>
            </form>
        </div>

        <div id="promocja">
            <h2>Dzięki rejestracji możesz:</h2>
            <ul>
                <li>Rezerwować ścianki</li>
                <li>Otrzymywać zniżki na wejścia</li>
                <li>Brać udział w naszych comiesięcznych zawodach</li>
                <li>... i wiele więcej</li>
            </ul>
            <p>Dołącz już teraz!</p>
            <?php
                if(isset($_SESSION['zarejestrowany']))
                {
                    echo "<h3>Dziękujemy za rejestrację!</h3>";
                }
                unset($_SESSION['zarejestrowany']);
            ?>
        </div>
    </div>
    <script src="../js/menu.js"></script>
</body>
</html>