<?php

$id = new mysqli('localhost','root','','baza_sw');
mysqli_query($id,'set names UTF8');

$najId = $id -> query("SELECT id FROM cennik ORDER BY id DESC LIMIT 1");
while($wyn = $najId -> fetch_row())
{
    $naj = $wyn[0];
}

if(isset($_POST['dodaj']))
{
    if(isset($_POST['nowa_nazwa']) && isset($_POST['nowa_cena']))
    {

        $id -> query("INSERT INTO cennik (nazwa,cena) VALUES ('".$_POST['nowa_nazwa']."','".$_POST['nowa_cena']."')");

        $rezultat2 = $id -> query("SELECT * FROM cennik");

        while($wypis2 = $rezultat2 -> fetch_assoc())
        {
            $m = $wypis2['id'];
        }

        $id -> query("ALTER TABLE kupionebilety ADD COLUMN bilet$m INT;");
        $id -> query("ALTER TABLE kupionebilety ADD COLUMN biletData$m DATE;");
        
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
            $rezultat2 = $id -> query("SELECT * FROM cennik");

            while($wypis2 = $rezultat2 -> fetch_assoc())
            {
                $m = $wypis2['id'];
            }

            $id -> query("ALTER TABLE kupionebilety DROP COLUMN bilet$m;");
            $id -> query("ALTER TABLE kupionebilety DROP COLUMN biletData$m;");
            
            $id -> query("DELETE FROM cennik WHERE id = $i");
        }
        if(!empty($_POST['nazwa'.$i.'']) && !empty($_POST['cena'.$i.'']))
        {
            $id -> query("UPDATE cennik SET nazwa = '".$_POST['nazwa'.$i.'']."', cena = '".$_POST['cena'.$i.'']."' WHERE id = ".$i);
        }
        else
        {

        }
    }
}

?>
<div id="biletyCenter">
    <form action="panel.php" method="post" id="biletyForm">
        <div id="dodajBilet">
            <h1>Dodaj bilet</h1><br><br><br>
            <table>
                <tr><th>Nazwa</th><th>Cena</th></tr>
                <tr><td><textarea cols='25' rows='5' name="nowa_nazwa"></textarea></td><td><textarea cols='10' rows='5' name="nowa_cena"></textarea></td></tr>
            </table>
            <input type="submit" name="dodaj" value="Dodaj">
        </div>
        
        <div id="listaBiletow">
            <h1>Lista biletów</h1><br><br>
            <table id="biletyTab">
                <tr><th>Nazwa</th><th>Cena</th><th>Do usunięcia</th></tr>
                <?php

                    $rezultat = $id -> query("SELECT * FROM cennik");

                    while($wypis = $rezultat -> fetch_assoc())
                    {
                        $j = $wypis['id'];
                        echo "<tr><td><textarea cols='25' rows='5' name='nazwa$j' class='nazwa'>".$wypis['nazwa']."</textarea></td><td><textarea cols='10' rows='5' name='cena$j' class='cena'>".$wypis['cena']."</textarea></td>";
                        echo "<td class='aktUsun'><input type='checkbox' name='czy_usun$j'></td>";
                        echo "</tr>";
                    }
                ?>
            </table>
            <input type="submit" name="zapisz" value="Zapisz zmiany"><br>
        </div>
    </form>    
</div>
