<?php
    session_start();

    if(!isset($_SESSION['zalogowany']))
    {
        header ('Location: index.php');
        exit();
    }

    $id = mysqli_connect('localhost','root','','baza_sw');
    mysqli_query($id,'set names UTF8');
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STREFA WOLNOŚCI - Panel użytkownika</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/panelStyle.css">
    <?php
    if($_SESSION['admin'] == 'nie')
    {
        echo "
        <link rel='stylesheet' href='../css/kupowanie.css'>
        <link rel='stylesheet' href='../css/dziekujemyStyle.css'>
        <link rel='stylesheet' href='../css/twojeBiletyStyle.css'>
        ";
    }
    else if($_SESSION['admin'] == 'tak')
    {
        echo "
        <link rel='stylesheet' href='../css/biletyStyle.css'>
        <link rel='stylesheet' href='../css/aktualnoscStyle.css'>
        <link rel='stylesheet' href='../css/uzytkownikStyle.css'>
        <link rel='stylesheet' href='../css/potwierdzenieStyle.css'>
        ";
    }
    ?>
    
    
    
    
</head>
<body>
    <?php
        require_once 'menu.php';
    ?>

    <div id="wszystkoContainer">
        <div id="podmenu">
            <?php
            if($_SESSION['admin'] == 'nie')
            {
                echo "<div class='zakladki' onclick='podmenu(1, 0)'><p>Panel główny</p></div>";
                echo "<div class='zakladki' onclick='podmenu(2, 0)'><p>Kup bilet</p></div>";
                echo "<div class='zakladki' onclick='podmenu(3, 0)'><p>Twoje bilety</p></div>";
            }
            else if($_SESSION['admin'] == 'tak')
            {
                echo "<div class='zakladki' onclick='podmenu(1, 1)'><p>Panel główny</p></div>";
                echo "<div class='zakladki' onclick='podmenu(2, 1)'><p>Wszyscy użytkownicy</p></div>";
                echo "<div class='zakladki' onclick='podmenu(3, 1)'><p>Aktualności</p></div>";
                echo "<div class='zakladki' onclick='podmenu(4, 1)'><p>Bilety</p></div>";
                echo "<div class='zakladki' onclick='podmenu(5, 1)'><p>Potwierdzenie płatności</p></div>";
            }
            ?>
            <a href="logout.php" class='zakladki'><div><p>Wyloguj się</p></div></a>
        </div>
        <div id="zawartosc">
            <?php
                echo "
                <div id='panel1' class='panel'>
                    <h1>Witaj w Strefie Wolności,</h1>
                    <h3>".$_SESSION['imie']."</h3>
                    <p>Dziękujemy, że nas wybrałeś</p>
                    <p>Zapraszamy do aktywności</p>
                </div>";

                if($_SESSION['admin'] == 'nie')
                {   
                    if(isset($_SESSION['czy_kupil']))
                    {
                        echo "<div id='panel2' class='panel'>";
                        require_once 'dziekujemy.php';
                        echo "</div>";
                        unset($_SESSION['czy_kupil']);
                    }
                    else
                    {
                        echo "<div id='panel2' class='panel'>";
                        require_once 'kupBilet.php';
                        echo "</div>";
                    }

                    echo "<div id='panel3' class='panel'>";
                    require_once 'twojeBilety.php';
                    echo "</div>";

                    
                }
                else if($_SESSION['admin'] == 'tak')
                {
                    echo "<div id='panel2' class='panel'>";
                    require_once 'uzytkownicy.php';
                    echo "</div>";

                    echo "<div id='panel3' class='panel'>";
                    require_once 'aktualnosc.php';
                    echo "</div>";

                    echo "<div id='panel4' class='panel'>";
                    require_once 'bilety.php';
                    echo "</div>";

                    echo "<div id='panel5' class='panel'>";
                    require_once 'potwierdzenie.php';
                    echo "</div>";
                }
                ?>
        </div>
    </div>

    <script src="../js/panel.js"></script>
    <script src="../js/menu.js"></script>
</body>
</html>