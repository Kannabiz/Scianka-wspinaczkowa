<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STREFA WOLNOŚCI - Cennik</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cennikStyle.css">
</head>
<body>
    <?php
        $id = mysqli_connect('localhost','root','','baza_sw');
        mysqli_query($id,'set names UTF8');
        
        $zapytanie = $id -> query("SELECT * FROM cennik");
        
        require_once 'menu.php';
    ?>

    <div id="biletyContainer">
        <h2>Cennik</h2>
        <?php
        while($wypis = $zapytanie -> fetch_assoc())
        {
            echo "<div class='bilet'><div class='nazwa'>".$wypis['nazwa']."</div><div class='cena'>".$wypis['cena']." zł</div></div>";
        }
        ?>
    </div>

    <script src="../js/menu.js"></script>
</body>
</html>