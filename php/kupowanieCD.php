<?php
    session_start();
    $id = mysqli_connect('localhost','root','','baza_sw');


    $zapytanie1 = $id -> query("SELECT * FROM cennik");
    $uzytkownikId = $_SESSION['id'];

    $id -> query("INSERT INTO kupionebilety (id_uzytkownik) VALUES ('".$uzytkownikId."')");

    $najId = $id -> query("SELECT id FROM kupionebilety ORDER BY id DESC LIMIT 1");
    while($wyn = $najId -> fetch_row())
    {
        $naj = $wyn[0];
    }

    while($wypis = $zapytanie1 -> fetch_assoc())
    {
        $j = $wypis['id'];
        // $data = date('Y-m-d', strtotime($_POST['data'.$j]));
        
        $id -> query("UPDATE kupionebilety SET bilet$j = '".$_POST['ilosc'.$j]."', biletData$j = '".$_POST['data'.$j]."' WHERE id = $naj");
    }

    $_SESSION['czy_kupil'] = 1;

    header('Location: panel.php');
?>