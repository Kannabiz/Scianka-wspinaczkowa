<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="utf8mb4_unicode_ci">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STREFA WOLNOŚCI - Ścianka Wspinaczkowa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
        $id = mysqli_connect('localhost','root','','baza_sw');
        mysqli_query($id,'set names UTF8');
        
        $dane = 'SELECT * FROM aktualnosci ORDER BY id DESC LIMIT 5;';

        $zapytanie1 = mysqli_query($id, $dane);
        $zapytanie2 = mysqli_query($id, $dane);

        require_once 'menu.php';
    ?>

    <div id="slider"><img src='../img/Slider1.png' id='sliderZdj' alt='zdjęcie ze slidera'></div>

    <div id="aktualnosci">
        <h1>AKTUALNOŚCI</h1>
        <?php

            $m = 0;
            while($wypis = $zapytanie1 -> fetch_assoc())
            {
                $m++;
                echo"
                    <div class='akt' onclick='aktO($m)'>
                        <h2>$wypis[tytul]</h2>
                        <p>$wypis[opis]</p>
                        <img src='../img/akt/$wypis[zdj_link]' alt='zdjęcie aktualności'>
                    </div>
                    ";
            }
        ?>

        <div id="aktContainer">

        <?php
            $m = 0;

            while($wypis2 = mysqli_fetch_row($zapytanie2))
            {
                $m++;
                echo"
                    <div class='info invisT' id='info$m'>
                        <h2>$wypis2[1]</h2>
                        <p>$wypis2[3]</p>
                        <p class='autor'>$wypis2[5]</p>
                        <img src='../img/exit_transparent.png' alt='przycisk menu' class='przycisk' onclick='aktZ($m)'>
                    </div>
                    ";
            }
        ?>
        </div>

    </div>

    <div id="stopka">
        <p>Stronę stworzył: Adam Kosak</p>
    </div>

    <?php
        echo "<script src='../js/aktualnosci.js'></script>";
        echo "<script src='../js/menu.js'></script>";
        echo "<script src='../js/slider.js'></script>";

        mysqli_close($id);
    ?>

</body>
</html>






























































<!-- NIE pozdrawiam admina !!1!1!!! -->