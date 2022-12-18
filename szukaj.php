<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Szukaj</title>
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
    
    <form method="GET">

        <select name="wybor_typu">
            <option value="po_id">Szukaj po id mema</option>
            <option value="po_tagu">Szukaj po tagu</option>
        </select>
</br>
        <input type="text" id='szukaj' name='tag'>
        <input type="submit" value="SZUKAJ">

    </form>
    <?php
        $polacz = mysqli_connect('localhost','root','','memy');
        $sciezka = "MEMY\a";
        $sciezka = substr($sciezka, 0, -1);
        $wyniki_tagi = "TAGI: ";

        if(!empty($_GET['tag'])){

            $tag = $_GET['tag'];
            $szukaj = mysqli_query($polacz,"SELECT * from pliki join tagi on pliki.id=tagi.id_mema where tagi.tag='$tag'");

            while($wynik = mysqli_fetch_array($szukaj)){

                $nazwa = $wynik['nazwa'];
                $rozszerzenie = $wynik['rozszerzenie'];
                $id = $wynik['id'];

                if($rozszerzenie == "MP4" || $rozszerzenie == "WEBM"){

                    echo "
                    </br>
                    </br>   
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

                    echo "</div>";
                            
                }
                elseif($rozszerzenie == "PNG" || $rozszerzenie == "JPG" || $rozszerzenie == "GIF" || $rozszerzenie == "JPEG"){

                    echo "
                    </br>
                    </br>
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

                    echo "</div>";
        
                }else{
                    echo "Nieznany format";
                };
        
            };
            
        }else{
            echo "
            <img src='szukaj.gif' style='height: 665px;'>
            ";
        }

        //POPULARNE TAGI

        $popularne = mysqli_query($polacz,"SELECT tag from tagi group by tag");

        echo "<div id='popularne'>TAGI:";
        while($wyniki = mysqli_fetch_array($popularne)){
            $wyniki_tag = $wyniki['tag'];
            echo "
            <form action='szukaj.php' method='GET'>
            <button type=submit value='$wyniki_tag' name='tag'>$wyniki_tag</button>
            </form>";
        };
        
        echo "</div>";
        
    
    ?>
</div>

    <?php
    mysqli_close($polacz)
    ?>

</div>

<script src="script.js"></script>
</body>
</html>