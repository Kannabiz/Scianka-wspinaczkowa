<?php

$id = new mysqli('localhost','root','','baza_sw');

$najId = $id -> query("SELECT id FROM uzytkownik ORDER BY id DESC LIMIT 1");
while($wyn = $najId -> fetch_row())
{
    $naj = $wyn[0];
}


if(isset($_POST['zapisz']))
{
    for ($i = 0; $i < $naj+1; $i++)
    {
        if(isset($_POST['czy_admin'.$i]))
        {
            $zmiana = $id -> query("UPDATE uzytkownik SET admin = 'tak' WHERE id = $i");
        }
        else
        {
            $zmiana = $id -> query("UPDATE uzytkownik SET admin = 'nie' WHERE id = $i");
        }

        if(isset($_POST['czy_usun'.$i]))
        {
            $zmiana = $id -> query("DELETE FROM uzytkownik WHERE id = $i");
        }
    }
}
?>
<div id="uzytkCenter">
<form action="panel.php" method="post" id="uzytkownicyForm">
    <h1>Użytkownicy</h1><br><br>
    <table id="uzytkownicyTab">
        <tr><th>Imię</th><th>Nazwisko</th><th>Telefon</th><th>E-mail</th><th>Admin</th><th>Do usunięcia</th></tr>
        <?php

            $rezultat = $id -> query("SELECT * FROM uzytkownik");

            while($wypis = $rezultat -> fetch_assoc())
            {
                echo "<tr><td>".$wypis['imie']."</td><td>".$wypis['nazwisko']."</td><td>".$wypis['telefon']."</td><td>".$wypis['email']."</td>";
                $j = $wypis['id'];

                if($wypis['admin'] == 'nie')
                {
                    echo "<td><input type='checkbox' name='czy_admin$j'></td>";
                }
                else
                {
                    echo "<td><input type='checkbox' name='czy_admin$j' checked></td>";
                }
                echo "<td><input type='checkbox' name='czy_usun$j'></td>";
                echo "</tr>";
            
            }
            
            mysqli_close($id);
        ?>
    </table>
    <input type="submit" name="zapisz" value="Zapisz zmiany">
</form>
</div>