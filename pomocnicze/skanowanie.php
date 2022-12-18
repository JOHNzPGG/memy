<?php

$sciezka = "MEMY2\a";
$sciezka = substr($sciezka, 0, -1);
$polacz = mysqli_connect('localhost','root','','memy');
$a = scandir($sciezka);
print_r($a);
foreach($a as $wynik){
//$ins = mysqli_query($polacz,"INSERT INTO memy(nazwa) VALUES ('$wynik')");
};
mysqli_close($polacz);
?>