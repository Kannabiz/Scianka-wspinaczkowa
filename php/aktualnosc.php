<?php

$code = 303;

if (isset($_POST['nowy_tytul']) || isset($_POST['nowy_opis']) || isset($_POST['nowa_tresc']) || isset($_FILES['nowe_zdj']) || isset($_POST['nowy_autor']))
{
    header('Location:panel.php', true, $code);
}

$id = new mysqli('localhost','root','','baza_sw');
mysqli_query($id,'set names UTF8');
$blad = "";

$najId = $id -> query("SELECT id FROM aktualnosci ORDER BY id DESC LIMIT 1");
while($wyn = $najId -> fetch_row())
{
    $naj = $wyn[0];
}

if(isset($_POST['dodaj']))
{
    $lokalizacja = "../img/akt/";
    $zdjecie = $lokalizacja.basename($_FILES["nowe_zdj"]["name"]);
    $wPorzadku = 1;
    $typZdjecia = strtolower(pathinfo($zdjecie,PATHINFO_EXTENSION));

    if(!empty($_POST['nowy_tytul']) && !empty($_POST['nowy_opis']) && !empty($_POST['nowa_tresc']) && !empty($_FILES['nowe_zdj']) && !empty($_POST['nowy_autor']))
    {
        $check = getimagesize($_FILES["nowe_zdj"]["tmp_name"]);
        if($check !== false)
        {
            $wPorzadku = 1;
        }
        else
        {
            $blad = "Plik nie jest zdjęciem";
            $wPorzadku = 0;
        }
        if(file_exists($zdjecie))
        {
            $blad = "Przepraszamy, takie zdjęcie już istnieje";
            $wPorzadku = 0;
        }
        if($typZdjecia != "jpg" && $typZdjecia != "png" && $typZdjecia != "jpeg" && $typZdjecia != "gif" )
        {
            $blad = "Przepraszamy, możesz przesłać tylko zdjęcia z rozszerzeniem JPG, JPEG, PNG & GIF";
            $wPozradku = 0;
        }
        if($wPorzadku == 1)
        {
            if (move_uploaded_file($_FILES["nowe_zdj"]["tmp_name"], $zdjecie))
            {
                $dodanie = $id -> query("INSERT INTO aktualnosci (tytul,opis,tresc,zdj_link,autor) VALUES ('".$_POST['nowy_tytul']."','".$_POST['nowy_opis']."','".$_POST['nowa_tresc']."','".basename($_FILES["nowe_zdj"]["name"])."','".$_POST['nowy_autor']."')");
            }
            else
            {
                $blad = "Przepraszamy, wystąpił błąd podczas przesyłania zdjęcia";
            }
        }
    }
    else
    {
        echo "Błąd!";
    }
}

if(isset($_POST['zapisz']))
{
    for($i = 1; $i < $naj+2; $i++)
    {
        if(isset($_POST['czy_usun'.$i]))
        {
            $zapytanie = $id -> query("SELECT zdj_link FROM aktualnosci WHERE id = $i");
            while($wyn = $zapytanie -> fetch_row())
            {
                $zdj = $wyn[0];
            }
            if(file_exists("../img/akt/".$zdj))
            {
                unlink("../img/akt/".$zdj);
            }
            else
            {

            }
            $zmiana = $id -> query("DELETE FROM aktualnosci WHERE id = $i");
            
        }
        if(isset($_POST['tytul'.$i.'']) || isset($_POST['opis'.$i.'']) || isset($_POST['tresc'.$i.'']) || isset($_POST['autor'.$i.'']))
        {
            $zmiana = $id -> query("UPDATE aktualnosci SET tytul = '".$_POST['tytul'.$i.'']."', opis = '".$_POST['opis'.$i.'']."', tresc = '".$_POST['tresc'.$i.'']."', autor = '".$_POST['autor'.$i.'']."' WHERE id = ".$i."");
        }
        else
        {

        }
    }
}
?>
<div id="aktCenter">
    <form action="aktualnosc.php" method="post" enctype="multipart/form-data"  id="aktualnoscForm">
        <div id="aktDodanie">
            <h1>Dodaj aktualność</h1><br><br><br>
            <table>
                <tr><th>Tytuł</th><th>Opis</th><th>Treść</th><th>Autor</th><th>Zdjęcie</th></tr>
                <tr>
                    <td><textarea name="nowy_tytul" cols="15" rows="5"></textarea></td>
                    <td><textarea name="nowy_opis" id="" cols="20" rows="5"></textarea></td>
                    <td><textarea name="nowa_tresc" id="" cols="30" rows="5"></textarea></td>
                    <td><textarea name="nowy_autor" id="" cols="20" rows="5"></textarea></td>
                    <td><input type="file" accept=".jpg, .jpeg, .png" name="nowe_zdj">
                    <?php
                    echo $blad;
                    ?>
                    </td>
                </tr>
            </table>
            <input type="submit" name="dodaj" value="Dodaj"><br><br>
        </div>
        
        <div id="aktLista">
        <table id="aktualnoscTab">
            <h1>Wszystkie aktualności</h1><br><br>
            <tr><th>Tytuł</th><th>Opis</th><th>Treść</th><th>Autor</th><th>Do usunięcia</th></tr>
            <?php

                $rezultat = $id -> query("SELECT * FROM aktualnosci");

                while($wypis = $rezultat -> fetch_assoc())
                {
                    $j = $wypis['id'];
                    echo "<tr><td><textarea rows=5 cols=15 name='tytul$j'>".$wypis['tytul']."</textarea></td><td><textarea rows=5 cols=20 name='opis$j'>".$wypis['opis']."</textarea></td><td><textarea rows='5' cols='30' name='tresc$j'>".$wypis['tresc']."</textarea></td><td><textarea rows=5 cols=20 name='autor$j'>".$wypis['autor']."</textarea></td>";
                    echo "<td class='aktUsun'><input type='checkbox' name='czy_usun$j'></td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <input type="submit" name="zapisz" value="Zapisz zmiany">
    </div>
    </form>
</div>