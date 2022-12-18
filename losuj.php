<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Losuj</title>
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
        //połącznie i ścieżka
        $polacz = mysqli_connect('localhost','root','','memy');
        $sciezka = "MEMY\a";
        $sciezka = substr($sciezka, 0, -1);

        //ciasto do tagów
        if(!empty($_COOKIE['insert_id'])){
            $insert_id = $_COOKIE['insert_id'];
        };

        $sprawdz_maks = mysqli_query($polacz,"SELECT COUNT(id) as 'liczba' from pliki");
        while($wyniki1 = mysqli_fetch_array($sprawdz_maks)){
            $maks = $wyniki1['liczba'];
        };
        
        $losowe_id = rand(1,$maks);

        setcookie('insert_id', $losowe_id, time()+3600);
                    
        //ładowanie mema
        $sel = mysqli_query($polacz,"SELECT nazwa, rozszerzenie from pliki where id=$losowe_id");
        while($wyniki2 = mysqli_fetch_array($sel)){
            $nazwa = $wyniki2['nazwa'];
            $id = $losowe_id;
            $rozszerzenie = $wyniki2['rozszerzenie'];
        };
        if($rozszerzenie == "MP4" || $rozszerzenie == "WEBM"){

            echo "
            <div id='mem'>
            <video height='800' width='800' controls id='video'>
            <source src='$sciezka$nazwa.$rozszerzenie' alt='$nazwa' type='video/mp4'>
            </video>
            </br>
            ";

            echo "
            <form method='GET'>
            <input type=text name='tag_do_dodania'>
            <input type=submit value='DODAJ do $id'>
            </form>
            </br></br></br>
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

            echo "
            <form method='GET'>
            <input type=text name='tag_do_dodania'>
            <input type=submit value='DODAJ do $id'>
            </form>
            </br>
            </div>
            ";
        
        }
        else{
            echo "Nieznany format";
        };

        //obecne tagi
        $szukaj_tagi = mysqli_query($polacz,"SELECT tag from tagi where id_mema = $losowe_id");
        while($wynik_szukaj_tagi = mysqli_fetch_array($szukaj_tagi)){
            $tagi_mema = $wynik_szukaj_tagi['tag'];
            echo "
            <button class = 'tag'>#$tagi_mema</button>
            ";
        };

    
        if(!empty($_GET['tag_do_dodania'])){

            $tag_do_dodania = $_GET['tag_do_dodania'];
            //sprawdzanie czy tagi tak instnieje przy tym memie 

            //$sprawdz_tag = mysqli_query($polacz,"SELECT tag from tagi where id_mema = $insert_id AND tag = '$tag_do_dodania'");
            //while($wyniki_sprawdzania = mysqli_fetch_array($sprawdz_tag)){
                //if($wyniki_sprawdzania['tag'] == ""){
                    //echo "--->".$wyniki_sprawdzania['tag']."<---";
                    $wstawianie_taga = mysqli_query($polacz,"INSERT INTO tagi VALUES ($insert_id,'$tag_do_dodania')");
                //};
            //};

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