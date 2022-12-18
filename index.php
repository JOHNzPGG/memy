<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Memy</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="strona">
<div class="nav">

    <a href="index.php"><img id='logo' src='obrazy/logo.jpg' alt='logo'></a>

    <div class="linki">
    <a href="szukaj.php" class="szukaj">Szukaj</a>
    <a href="losuj.php"><img class="losuj" src='obrazy/losuj.png' alt='losuj'></a>
    <a href="logowanie.php" class="logowanie">Logowanie</a>
    </div>

</div>
<div id="zawartosc">
    <?php

    $polacz = mysqli_connect('localhost','root','','memy') or die('Brak połączenia z serwerem MySQL');

        
    if(!empty($_GET['strona'])){
        $strona = $_GET['strona'];
    }
    else{
        $strona = 1;
    };

    $sciezka = "MEMY\a";
    $sciezka = substr($sciezka, 0, -1);
    $strona_max = $strona*10;
    $strona_min = $strona_max-9;
    
    $sel = mysqli_query($polacz,"SELECT * from pliki where id<=$strona_max AND id>=$strona_min");

    while($wynik = mysqli_fetch_array($sel)){
        $nazwa = $wynik['nazwa'];
        $id = $wynik['id'];
        $rozszerzenie = $wynik['rozszerzenie'];

        if($rozszerzenie == "MP4" || $rozszerzenie == "WEBM"){

            echo "
            <div id='mem'>
            <video height='800' width='800' controls id='video'>
            <source src='$sciezka$nazwa.$rozszerzenie' alt='$nazwa' type='video/mp4'>
            </video>
            </br>
            ";

            //obecne tagi
            $szukaj_tagi = mysqli_query($polacz,"SELECT tag from tagi where id_mema = $id");
            while($wynik_szukaj_tagi = mysqli_fetch_array($szukaj_tagi)){
                        
                $tagi_mema = $wynik_szukaj_tagi['tag'];
                echo "
                <button class = 'tag'>#$tagi_mema</button>
                ";
                        
            };
            

            echo "
            <form method='GET'>
            <input type=text name='dodaj_tag_$id'>
            <input type=submit value='DODAJ'>
            </form>
            </br></br>
            </div>
            ";

        }elseif($rozszerzenie == "PNG" || $rozszerzenie == "JPG" || $rozszerzenie == "GIF" || $rozszerzenie == "JPEG"){

            echo "
            <div id='mem'>
            <img id='zdj' 
            src='$sciezka$nazwa.$rozszerzenie' 
            alt='$nazwa'>
            </br>
            ";

            //obecne tagi
            $szukaj_tagi = mysqli_query($polacz,"SELECT tag from tagi where id_mema = $id");
            while($wynik_szukaj_tagi = mysqli_fetch_array($szukaj_tagi)){
            
                $tagi_mema = $wynik_szukaj_tagi['tag'];
                echo "
                <button class = 'tag'>#$tagi_mema</button>
                ";
            
            };

            echo "
            <form method='GET'>
            <input type=text name='dodaj_tag_$id'>
            <input type=submit value='DODAJ'>
            </form>
            </br></br>
            </div>
            ";
        
        }
        else{
            echo "Nieznany format";
        };

    };
        
    for($i = $strona_min; $i <= $strona_max; $i++){
        if(!empty($_GET['dodaj_tag_'.$i])){

        $dodaj_tag = $_GET['dodaj_tag_'.$i];

        $ins = mysqli_query($polacz,"INSERT INTO tagi VALUES ($i,'$dodaj_tag')");

        };
    };
        
    ?>

<form method="GET" action="index.php">
    <?php

    $strony = mysqli_query($polacz,"SELECT COUNT(id) as 'liczba' from pliki");
    while($wyniki = mysqli_fetch_array($strony)){
        $liczba_stron = $wyniki['liczba'];
    };
    $liczba_stron = $liczba_stron/10;
    $liczba_stron = ceil($liczba_stron);
    $stronam2 = $strona - 2;
    $stronam1 = $strona - 1;
    $stronap1 = $strona + 1;
    $stronap2 = $strona + 2;
    if($strona == 1){//pierwsza strona

        echo "<input type='submit' value='1' name='strona'>";
        echo "<input type='submit' value='2' name='strona'>";
        echo "<input type='submit' value='3' name='strona'>";
        echo "<input type='submit' value='4' name='strona'>";
        echo "<input type='submit' value='5' name='strona'>";
        echo "<input type='submit' value='$liczba_stron'name='strona'>";

    }
    elseif($strona == 2){//druga strona

        echo "<input type='submit' value='1' name='strona'>";
        echo "<input type='submit' value='2' name='strona'>";
        echo "<input type='submit' value='3' name='strona'>";
        echo "<input type='submit' value='4' name='strona'>";
        echo "<input type='submit' value='5' name='strona'>";
        echo "<input type='submit' value='$liczba_stron'name='strona'>";
        
    }
    elseif($strona == $liczba_stron - 2){//strona dwie od końca

        echo "<input type='submit' value='1'name='strona'>";
        echo "<input type='submit' value='$stronam2'     name='strona'>";
        echo "<input type='submit' value='$stronam1'     name='strona'>";
        echo "<input type='submit' value='$strona'       name='strona'>";
        echo "<input type='submit' value='$stronap1'     name='strona'>";
        echo "<input type='submit' value='$liczba_stron' name='strona'>";
        
    }elseif($strona == $liczba_stron - 1){//strona od końca

        echo "<input type='submit' value='1'name='strona'>";
        echo "<input type='submit' value='$stronam2'     name='strona'>";
        echo "<input type='submit' value='$stronam1'     name='strona'>";
        echo "<input type='submit' value='$strona'       name='strona'>";
        echo "<input type='submit' value='$stronap1'     name='strona'>";
        
    }elseif($strona == $liczba_stron){//ostatnia strona

        echo "<input type='submit' value='1'name='strona'>";
        echo "<input type='submit' value='$stronam2'     name='strona'>";
        echo "<input type='submit' value='$stronam1'     name='strona'>";
        echo "<input type='submit' value='$strona'       name='strona'>";
        
    }else{//wszystkie inne strony
        
        echo "<input type='submit' value='1'name='strona'>";
        echo "<input type='submit' value='$stronam2'     name='strona'>";
        echo "<input type='submit' value='$stronam1'     name='strona'>";
        echo "<input type='submit' value='$strona'       name='strona'>";
        echo "<input type='submit' value='$stronap1'     name='strona'>";
        echo "<input type='submit' value='$stronap2'     name='strona'>";
        echo "<input type='submit' value='$liczba_stron' name='strona'>";

    };

    ?>
</form>
</div>

    <?php
    mysqli_close($polacz)
    ?>

</div>

<script src="script.js"></script>
</body>
</html>