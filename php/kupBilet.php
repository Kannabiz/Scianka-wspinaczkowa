<?php
    $id = mysqli_connect('localhost','root','','baza_sw');
    mysqli_query($id,'set names UTF8');
    
    $zapytanie = $id -> query("SELECT * FROM cennik");

    $dzisiaj = time();
    $dzisiejszaData = date('Y-m-d');
    $koncowaData = date('Y-m-d', strtotime('+30 day', $dzisiaj));
?>
<div id="kupowanieContainer">
    <form action="kupowanieCD.php" method="post" id="kupowanieForm">
        <h2>Jakie bilety chcesz kupić?</h2>
        <table id="kupowanieTab">
            <tr><th>Nazwa</th><th>Cena</th><th>Ilość</th><th>Data realizacji</th></tr>
            <?php
                while($wypis = $zapytanie -> fetch_assoc())
                {
                    $j = $wypis['id'];
                    echo "
                    <tr>
                        <td><div class='nazwaK'>".$wypis['nazwa']."</div></td>
                        <td><div class='cenaK'>".$wypis['cena']." zł</div></td>
                        <td><input type='number' name='ilosc$j' class='iloscK' value=0 min=0></td>
                        <td><input type='date' name='data$j' class='dataK' value=$dzisiejszaData min=$dzisiejszaData max=$koncowaData></td>
                    </tr>";
                }
            ?>
        </table>
        <input type="submit" value="Przejdź dalej">
    </form>
</div>
