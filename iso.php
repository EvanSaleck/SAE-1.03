#!/usr/bin/php
<?php

$isofile = fopen("iso.txt","x+");
$fichier = file("Texte.dat");
foreach ($fichier as $indice => $ligne) {
    $mot=explode("<code>",$ligne);
    $tab_code=explode("</code>",$mot[0]);
    fwrite($isofile,"$tab_code[0]");
}

?>