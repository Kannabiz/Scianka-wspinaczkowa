<?php
$id = new mysqli('localhost','root','','baza_sw');
mysqli_query($id,'set names UTF8');

$cennikId = $id -> query("SELECT id FROM cennik");
$cennikNazwa = $id -> query("SELECT nazwa FROM cennik");
$zapytanie = $id -> query("SELECT * FROM kupionebilety WHERE id_uzytkownik = ".$_SESSION['id']."");

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

    echo "
    <div class='bilety'>
    <div class='akcept'><span class='mn'>Przelew zrobiony</span>".$wypis3['akceptacja']."</div>
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
    echo "</table>";
    echo "</div></div>";
}
echo "</div>"

?>