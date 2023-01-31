#!/usr/bin/php
<?php
   $lines = file('../region.conf');
   $trimestre = intval(date("m") / 3 + 1);
   $infosRegion = explode(":", $lines[1]);
   $region = strtoupper($argv[1]);
   $regionFR = "FR-$region";

   if ($argc == 2) {
   } else {
      echo "Nombre d'arguments invalides, il faut mettre l'identifiant de la région en paramètres";
      exit();
   }

   foreach ($lines as $line) {
      $infosRegion = explode(":", $line);
      if ($infosRegion[0] == "FR-$region") {
         break;
      }
   }
   // affiche l'année et le mois du type MM/YYYY
    $annee = date("m/Y");
   // affiche date et heure du type JJ/MM/AAAA HH:MM:SS
    $date = date("d/m/Y H:i:s");
   $img = "$region.png";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <title>Résultats trimestriels <?php echo $annee?></title>
</head>
<body>
    <section class="page1">
        <header>
        <img src="logos/FR-<?php echo htmlentities($img)?>" alt = "logo">
            <h1>Nom de la région :</h1>
            <p><?php echo htmlentities($infosRegion[1])?> </p>
            <hr>
        </header>
        <ul>
            <li>Population :</li>
            <p><?php echo htmlentities($infosRegion[2])?> habitants</p>
            <hr>
            <li>Superficie :</li>
            <p><?php echo htmlentities($infosRegion[3])?> km² </p>
            <hr>
            <li>Nombre de département</li>
            <p><?php echo htmlentities($infosRegion[4])?> départements </p>
            <hr>
        </ul>

        <footer>
            <p><?php echo $date?></p>
        </footer>
    </section>



   <section class="page2">
        <h1>Resultats Trimestriels <?php echo $annee?></h1>

        <?php
            $texte = file('Texte.dat');
         ?>

        <p><?php echo $texte[2]?> </p>
        <p><?php echo $texte[3]?></p>
        <table>
        <?php
            $tableau = file('Tableau.dat');
         ?>
            <tr>
                <th>Nom du produit</th>
                <th>Vente du trimestre</th>
                <th>Chiffre d'affaire du trimestre</th>
                <th>Ventes du même trimestre, année précédente</th>
                <th>Chiffre d'affaire du même trimestre, année précédente</th>
                <th>Evolution du CA en %age et en valeur absolue</th>
            </tr>
            <tr>
            <?php
            foreach ($tableau as $line) {
               echo $line;
            }
            ?>
            </tr>
        </table>

        <footer>
            <p><?php echo $date?></p>
        </footer>
    </section>

    <section class="page3">
        <h1>Nos meilleurs vendeur du trimestre</h1>
        <?php
            $comm = file('comm.dat');
         ?>

        <?php
            foreach ($comm as $line) {
            echo $line;
            }
         ?>

        <footer>
            <p><?php echo $date?></p>
        </footer>
    </section>

    <section class="page4">
      <img src="../qrcode/FR-<?php echo $region ?>" alt="QR code"> 

        <footer>
            <p><?php echo $date?></p>
        </footer>
    </section>


    <footer>
        <p><?php echo $date?></p>
    </footer>
</body>
</html>

<?php
   $ficfin = $region.'.html';
   // envoie le code html dans le $ficfin en html
    file_put_contents($ficfin, ob_get_clean());
?>