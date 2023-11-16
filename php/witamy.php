<?php
    session_start();

    if(!isset($_SESSION['udana_rejestracja']))
    {
        header ('Location: index.php');
        exit();
    }
    else
    {
        unset($_SESSION['udana_rejestracja']);
    }

    //usuwanie zmiennych pamiętających wartości z formularza

    if(isset($_SESSION['fr_imie'])) unset($_SESSION['fr_imie']);
    if(isset($_SESSION['fr_nazwisko'])) unset($_SESSION['fr_nazwisko']);
    if(isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
    if(isset($_SESSION['fr_telefon'])) unset($_SESSION['fr_telefon']);
    if(isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
    if(isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);

    //usuwanie błędów

    if(isset($_SESSION['e_imie'])) unset($_SESSION['e_imie']);
    if(isset($_SESSION['e_nazwisko'])) unset($_SESSION['e_nazwisko']);
    if(isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
    if(isset($_SESSION['e_telefon'])) unset($_SESSION['e_telefon']);
    if(isset($_SESSION['e_haslo1'])) unset($_SESSION['e_haslo1']);
    if(isset($_SESSION['e_haslo2'])) unset($_SESSION['e_haslo2']);

    $_SESSION['zarejestrowany'] = 1;
    header('Location: rejestracja.php');
?>