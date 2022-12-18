<?php
$polacz = mysqli_connect('localhost','root','','memy');

$sel = mysqli_query($polacz,"SELECT tagi.id_mema, memy_stare.nazwa, tagi.tag from tagi join memy_stare on memy_stare.id=tagi.id_mema group by id_mema");
while($wynik = mysqli_fetch_array($sel)){
    $id_mema = $wynik['id_mema'];
    $nazwa = $wynik['nazwa'];
    $tag = $wynik['tag'];

    $trzy_od = strtolower(substr($nazwa, -3));
    $cztery_od = strtolower(substr($nazwa, -4));

    //poczatek
    //obrazy
    if($trzy_od =="png"){
        $rozszerzenie = "PNG";
        $nazwa = substr($nazwa, 0, -4);
    }
    elseif($trzy_od == "jpg"){
        $rozszerzenie = "JPG";
        $nazwa = substr($nazwa, 0, -4);
    }
    elseif($trzy_od == "gif"){
        $rozszerzenie = "GIF";
        $nazwa = substr($nazwa, 0, -4);
    }
    elseif($cztery_od == "jpeg"){
        $rozszerzenie = "JPEG";
        $nazwa = substr($nazwa, 0, -5);
    }

    //filmy
    elseif($trzy_od =="mp4"){
        $rozszerzenie = "MP4";
        $nazwa = substr($nazwa, 0, -4);
    }
    elseif($cztery_od == "webm"){
        $rozszerzenie = "WEBM";
        $nazwa = substr($nazwa, 0, -5);
    }

    //dzwiek
    elseif($trzy_od =="mp3"){
        $rozszerzenie = "MP3";
        $nazwa = substr($nazwa, 0, -4);
    }
    elseif($trzy_od =="ogg"){
        $rozszerzenie = "OGG";
        $nazwa = substr($nazwa, 0, -4);
    }
    elseif($trzy_od =="wav"){
        $rozszerzenie = "WAV";
        $nazwa = substr($nazwa, 0, -4);
    }

    //inne
    else{
        $rozszerzenie = "inny";
    }
    //koniec
    
    $sel_szukaj = mysqli_query($polacz,"SELECT * from pliki where nazwa = '$nazwa' AND rozszerzenie = '$rozszerzenie'");
    while($wynik2 = mysqli_fetch_array($sel_szukaj)){
        $pliki_id = $wynik2['id'];
        $pliki_nazwa = $wynik2['nazwa'];
        $pliki_rozszerzenie = $wynik2['rozszerzenie'];
        echo "$pliki_id  ||  $pliki_nazwa  ||  $pliki_rozszerzenie  ||  $tag</br>";
        //$ins = mysqli_query($polacz,"INSERT INTO tagi_nowe VALUES ($pliki_id, '$tag')");

    };


};

mysqli_close($polacz);
?>