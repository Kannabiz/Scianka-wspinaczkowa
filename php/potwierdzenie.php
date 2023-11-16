<?php
$id = new mysqli('localhost','root','','baza_sw');
mysqli_query($id,'set names UTF8');

$najId = $id -> query("SELECT id FROM kupionebilety ORDER BY id DESC LIMIT 1");
while($wyn = $najId -> fetch_row())
{
    $naj = $wyn[0];
}

if(isset($_POST['zapisz']))
{
    for ($i = 0; $i < $naj+1; $i++)
    {
        if(isset($_POST['akcept'.$i]))
        {
            $zmiana = $id -> query("UPDATE kupionebilety SET akceptacja = 'tak' WHERE id = $i");
        }
        else
        {
            $zmiana = $id -> query("UPDATE kupionebilety SET akceptacja = 'nie' WHERE id = $i");
        }

        if(isset($_POST['usun'.$i]))
        {
            $zmiana = $id -> query("DELETE FROM kupionebilety WHERE id = $i");
        }
    }
}

$cennikId = $id -> query("SELECT id FROM cennik");
$cennikNazwa = $id -> query("SELECT nazwa FROM cennik");
$zapytanie = $id -> query("SELECT * FROM kupionebilety");

$cennikIdTab = array();
$cennikNazwaTab = array();

while($wypis = $cennikId -> fetch_assoc())
{
    $cennikIdTab[] = $wypis['id'];
}

while($wypis2 = $cennikNazwa -> fetch_assoc())
{
    $cennikNazwaTab[] = $wypis2['nazwa'];
}

echo "<div id='panelContainer'>";
while($wypis3 = $zapytanie -> fetch_assoc())
{
    $k = $wypis3['id'];
    echo "
    <form action='panel.php' method='post' class='potwierdzenieForm'>
    <div class='bilety'>
    <div class='id_uzytk'><span class='mn'>ID: </span><span class='wi'>".$wypis3['id_uzytkownik']."</span></div>";
    if($wypis3['akceptacja'] == 'tak')
    {
        echo "<div class='akcept'><span class='mn'>Przelew: </span><input type='checkbox' name='akcept$k' checked></div>";
    }
    else
    {
        echo "<div class='akcept'><span class='mn'>Przelew: </span><input type='checkbox' name='akcept$k'></div>";
    }
    echo "
    <div class='dane'>
    <table><tr><th>Nazwa</th><th>Ilość</th><th>Data</th></tr>";
    for($i=0; $i < count($cennikIdTab) - 1; $i++)
    {
        
        $j = $cennikIdTab[$i];

        if($wypis3['bilet'.$j.''] > 0)
        {
            echo "<tr><td>".$cennikNazwaTab[$i]."</td><td>".$wypis3['bilet'.$j.'']."</td><td>".$wypis3['biletData'.$j.'']."</td></tr>";
        }
        
    }
    echo "
    </table>
    <div class='usun'><p>Usuń</p><input type='checkbox' name='usun$k'></div>
    </div></div>";
}
echo "<input type='submit' value='zapisz' name='zapisz'></form></div>";

?>