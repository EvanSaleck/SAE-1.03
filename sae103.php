<?php
// Script qui permet de récupérer les données d'un fichier texte et de les stocker dans nos fichiers
// Récupération du contenu de tout les fichiers txt du dossier utilisation de Joker qui reperent juste le .txt et qui execute sur tout les .txt
$fileToTreat = __DIR__.'/fichiers.txt/*.txt';
// Récupération du contenu du fichier
$content = file_get_contents($fileToTreat);
// Récuperation du nom du fichier pris en compte
$fileName = basename($fileToTreat);

// Récupération du titre de la page 1 compris entre les balises DEBUT_TITRE et FIN_TITRE
$debutTitre = strpos($content,'SOUS_TITRE') + strlen('SOUS_TITRE');
$finTitre = strpos($content,'FIN_TITRE');
$titre = trim(substr($content,$debutTitre,$finTitre-$debutTitre));

// Récupération du texte de la page 1 compris entre les premières balises DEBUT_TEXTE et FIN_TEXTE
$premierDebutTexte = strpos($content,'DEBUT_TEXTE') + strlen('DEBUT_TEXTE');
$premierFinTexte = strpos($content,'FIN_TEXTE');
$descriptionTitre = trim(substr($content,$premierDebutTexte,$premierFinTexte-$premierDebutTexte));

// Récupération du titre du texte 2 compris entre les balises DEBUT_TITRE et FIN_TITRE
$debutTitre2 = strpos($content,'SOUS_TITRE',$premierFinTexte) + strlen('SOUS_TITRE');  // on commence à la fin du premier texte
$finTitre2 = strpos($content,'FIN_TITRE',$debutTitre2);
$titre2 = trim(substr($content,$debutTitre2,$finTitre2-$debutTitre2));

// Récupération du texte de la page 1 compris entre les balises DEBUT_TEXTE et FIN_TEXTE
$debutTexte = strpos($content,'DEBUT_TEXTE',$premierFinTexte) + strlen('DEBUT_TEXTE');  // on commence à la fin du premier texte 
$FinTexte = strpos($content,'FIN_TEXTE',$debutTexte);
$description = trim(substr($content,$debutTexte,$FinTexte-$debutTexte));

// Ajoute dans notre fichier $fileName_texte.dat toute les données récupérées précédemment portant les noms de variables $titre, $descriptiontitre, $titre2, $description 
file_put_contents(__DIR__.'/data_extraite/'.$fileName.'_texte.dat',json_encode([
    'titre' => $titre,
    'descriptionTitre' => $descriptionTitre,
    'titre2' => $titre2,
    'description' => $description
]));
// Fichier Texte.dat encodé avec un aspect JSON assez facile à réutiliser avec des Webfiles

// Récupération des stats
$debutStats = strpos($content,'DEBUT_STATS') + strlen('DEBUT_STATS');
$finStats = strpos($content,'FIN_STATS');
$stats = trim(substr($content,$debutStats,$finStats-$debutStats));

// si on veut retrailler les données
$explodedStats = explode(PHP_EOL,$stats);

$statsForJson = [];
if(count($explodedStats) > 0){
    foreach($explodedStats as $lineStat){
        $explodedLineStat = explode(',',$lineStat);
        list($titre, $col1, $col2, $col3, $col4) = $explodedLineStat;
        $statsForJson[] = [
            'titre' => $titre,
            'col1' => $col1,
            'col2' => $col2,
            'col3' => $col3,
            'col4' => $col4
        ];
    }
}

file_put_contents(__DIR__.'/data_extraite/'.$fileName.'tableau.dat',json_encode($statsForJson));

// Récupération des commerciaux
$debutMeilleursCommerciaux = strpos($content, 'MEILLEURS:') + strlen('MEILLEURS:');
$finMeilleursCommerciaux = strpos($content, PHP_EOL, $debutMeilleursCommerciaux);

$meilleurs = trim(substr($content,$debutMeilleursCommerciaux,$finMeilleursCommerciaux-$debutMeilleursCommerciaux));
$meilleursForJson = [];

$explodedMeilleurs = explode(',',$meilleurs);
if(count($explodedMeilleurs) > 0){
    foreach($explodedMeilleurs as $lineMeilleur){
        $regex = '/(.*)\/(.*)=(.*)/';
        preg_match($regex,$lineMeilleur,$output);
        $meilleursForJson[] = [
            'code' => $output[1],
            'nom' => $output[2],
            'ca' => $output[3]
        ];
    }
}

file_put_contents(__DIR__.'/data_extraite/'.$fileName.'comm.dat',json_encode($meilleursForJson));
