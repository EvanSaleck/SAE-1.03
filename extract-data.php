#!/usr/bin/php
<?php
	$test_txt=0;
	$test_stat=0;
	$test_emp=0;

    $fichier = file("FIC.txt");
    $txt = fopen("Texte.dat","x+");
	$stats = fopen("Tableau.dat","x+");
	$employes = fopen("comm.dat","x+");

foreach ($fichier as $indice => $ligne) {
	$ligne = trim($ligne);
	$tm1 = explode(" ", $ligne);
	$stat = explode("=", $tm1[0]);
	$meill = explode(":", $tm1[0]);

	if ($test_txt == 1) {
		if ($tm1[0] == "FIN_TEXTE") {
			$test_txt = 0;
			fwrite($txt, "</p>");
		} else {
			fwrite($txt, "$ligne");
		}
	}

	if ($tm1[0] == "DEBUT_TEXTE") {
		$test_txt = 1;
		fwrite($txt, "\n		<p>");
	}

	if ($stat[0] == "TITRE") {
		fwrite($txt, "\n		<h1>$stat[1]");
		foreach ($tm1 as $nb_mot => $content) {

			if ($nb_mot > 0) {
				fwrite($txt, "$content ");
			}
		}
		fwrite($txt, "</h1>");
	}


	if ($stat[0] == "SOUS_TITRE") {
		fwrite($txt, "\n		<h2>$stat[1]");
		foreach ($tm1 as $nb_mot => $content) {

			if ($nb_mot > 0) {
				fwrite($txt, " $content ");
			}
		}
		fwrite($txt, "</h2>");
	}





	if ($stat[0] == "CODE") {
		fwrite($txt, "\n<code>$stat[1]");
		foreach ($tm1 as $nb_mot => $content) {

			if ($nb_mot > 0) {
				fwrite($txt, " $content ");
			}
		}
		fwrite($txt, "</code>");
	}





	if ($test_stat == 1) {
		if ($tm1[0] == "FIN_STATS") {
			$test_stat = 0;

			fwrite($stats, "\n		</tbody>");
		} else {
			$data = explode(",", $ligne);

			fwrite($stats, "\n			<tr>");
			$i = 0;
			while ($i <= 4) {
				fwrite($stats, "\n				<td>$data[$i]</td>");
				$i++;
			}

			fwrite($stats, "\n				<td class=");
			$evo = $data[4] / $data[2];
			$evo = $evo * 100 - 100;
			if ($evo > 0) {
				fwrite($stats, '"green">');
				fwrite($stats, "$evo %</td>");
			} else {
				fwrite($stats, '"red">');
				fwrite($stats, "$evo	%</td>");
			}

			fwrite($stats, "\n			</tr>");

		}
	}


	if ($tm1[0] == "DEBUT_STATS") {
		$test_stat = 1;
		fwrite($stats, "\n			<tbody>");
	}








	if ($meill[0] == "MEILLEURS") {

		$transi = explode(":", $ligne);
		$emp = explode(",", $transi[1]);


		fwrite($employes, "		<ul>\n");


		$list = explode(",", $ligne);

		$employes = array();
		foreach ($list as $value) {
			$sublist = explode("=", $value);
			$employes[] = array('abr' => $sublist[0], 'affaires' => $sublist[1]);
		}

		usort($employes, function ($a, $b) {
			return $a['affaires'] < $b['affaires'];
		});

		// Sélectionner les 3 premiers employés
		$top3 = array_slice($employes, 0, 3);

		// Afficher les employés sélectionnés avec les balises HTML
		echo "<ul>\n";
		file_put_contents($file, "<ul>\n");
		foreach ($top3 as $employe) {
			$file = "comm.dat";
			file_put_contents($file, "    <li>\n", FILE_APPEND);
			file_put_contents($file, "        <figure>\n", FILE_APPEND);
			file_put_contents($file, "            <img src='images/".$employe['abr'].".png' alt='meilleur commerciaux'>\n", FILE_APPEND);
			file_put_contents($file, "            <br />\n", FILE_APPEND);
			file_put_contents($file, "            <figcaption>\n", FILE_APPEND);
			file_put_contents($file, "                <b>NOM: ".$employe['abr']."</b>\n", FILE_APPEND);
			file_put_contents($file, "                <br>\n", FILE_APPEND);
			file_put_contents($file, "                CA: ".$employe['affaires']."\n", FILE_APPEND);
			file_put_contents($file, "            </figcaption>\n", FILE_APPEND);
			file_put_contents($file, "        </figure>\n", FILE_APPEND);
			file_put_contents($file, "    </li>\n", FILE_APPEND);
		}
		file_put_contents($file, "</ul>", FILE_APPEND);
		




		
	}
}
?>