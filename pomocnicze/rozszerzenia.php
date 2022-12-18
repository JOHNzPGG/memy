<?php
$polacz = mysqli_connect('localhost','root','','memy');

$select = mysqli_query($polacz,"SELECT * from memy");

while($wynik = mysqli_fetch_array($select)){
    $id = $wynik['id'];
    $nazwa = $wynik['nazwa'];


    $trzy_od = strtolower(substr($nazwa, -3));
    $cztery_od = strtolower(substr($nazwa, -4));


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

    echo "$id  |  $nazwa  |  $rozszerzenie</br>";

    //mysqli_query($polacz,"INSERT INTO pliki(nazwa , rozszerzenie) VALUES ('$nazwa', '$rozszerzenie')");
};

mysqli_close($polacz);
?>