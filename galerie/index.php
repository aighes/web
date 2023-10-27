<?php

$url=$_SERVER['HTTP_HOST'];
$websitename = str_replace("www.","", $url);

function filename($name) {
	$name = str_replace("_", " ", $name);
	$name = str_replace("ae", "ä", $name);
	$name = str_replace("oe", "ö", $name);
	$name = str_replace("-", " - ", $name);
	$name = str_replace("ue", "ü", $name);
	return str_replace("eü", "eue", $name);
}//end function

function new_picture($image) {
	if ($image != '') {
		if (file_exists($image)) {
			$exif = exif_read_data($image, 'IFD0');
			if(isset($exif["EXIF"]["DateTimeOriginal"])) {
		        	$part=explode(':',substr($exif["EXIF"]["DateTimeOriginal"], 0, 10));
	        		$fbdateoriginal = $part[2].".".$part[1].".".$part[0];
	        		$dateoriginal = mktime(0, 0, 0, $part[1], $part[2], $part[0]);
		        	$datum = (time()-(60*60*24*30));
		        	if ($datum < $dateoriginal){
	        			return '<span class="newlabel">&nbsp;NEU&nbsp;</span>'."\n";
				}
			}
		}
	}
}
function read_exif($image) {
		if ($image != '') {
		$exif = exif_read_data($image, 0 , true);
	        	if(isset($exif["EXIF"]["DateTimeOriginal"])) {
	        		$part=explode(':',substr($exif["EXIF"]["DateTimeOriginal"], 0, 10));
				$fbtimeoriginal = substr($exif["EXIF"]["DateTimeOriginal"], 10);
	        		$fbdateoriginal = $part[2].".".$part[1].".".$part[0];
	        		$dateoriginal = mktime(0, 0, 0, $part[1], $part[2], $part[0]);
	        		$datum = (time()-(60*60*24*30));
	        		if ($datum < $dateoriginal){
					print ('<span class="newlabel">&nbsp;NEU&nbsp;</span>&nbsp;<b>Aufnahme vom:</b>') . " {$fbdateoriginal} - $fbtimeoriginal";
	         	        }
	                	else {
					print ('<b>Aufnahme vom:</b>') . " {$fbdateoriginal} - $fbtimeoriginal";
	                	}
		                print " | ";
		        }
		if(isset($exif["EXIF"]["FNumber"])) {
	               list($num,$den) = explode("/",$exif["EXIF"]["FNumber"]);
	               $fbaperture  = ($num/$den);
	               print ('<b>Blendenöffnung:</b>') . " {$fbaperture}";
	               print " | ";
	        }

		if(isset($exif["EXIF"]["ExposureTime"])) {
	               	list($num, $den) = explode("/", $exif["EXIF"]["ExposureTime"]);
	               	if ($num!=1) {
				if ($den!=0){
				$num = ($num/$den);
				$fbexposure = "{$num}s";
	                       	print ('<b>Belichtungszeit:</b>') . " {$fbexposure}";
	               	       	}
	               	       	else {
	                       	$fbexposure = "{$num}s";
	                       	print ('<b>Belichtungszeit:</b>') . " {$fbexposure}";
	                       	}
	               	}
	               	else {
	                	$den = $den/$num;
	                       	$fbexposure = "1/{$den}s";
	                       	print ('<b>Belichtungszeit:</b>') . " {$fbexposure}";
	               	}
	               	print " | ";
	        }

		if(isset($exif["EXIF"]["FocalLength"])) {
	               list($num, $den) = explode("/", $exif["EXIF"]["FocalLength"]);
	               $fbfocallength  = ($num/$den) . "mm";
	               print ('<b>Brennweite:</b>') . " {$fbfocallength}";
	               print " | ";
		}

		if (isset($exif["EXIF"]["ISOSpeedRatings"])) {
	               print ('<b>ISO:</b>') . " {$exif["EXIF"]["ISOSpeedRatings"]}";
	               print " | ";
		}

		if(isset($exif["EXIF"]["Flash"])) {
	               $fbflash = (bindec($exif["EXIF"]["Flash"]) ? "Yes" : "No");
	               print ('<b>Blitz:</b>') . " {$fbflash}";
	               print " | ";
		}

		if(isset($exif["IFD0"]["Make"]) && isset($exif["IFD0"]["Model"])) {
	               $fbmake = ucwords(strtolower($exif["IFD0"]["Make"]));
	               $fbmodel = ucwords($exif["IFD0"]["Model"]);
	               print ('<b>Kamera:</b>') . " {$fbmodel}";
		}
	}
}

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />'."\n";
echo '<meta name="Description" content="'.$event.'" />'."\n";
echo '<link rel="stylesheet" type="text/css" href="../res/styles.css" />'."\n";
echo '<style type="text/css">'."\n";
echo 'body { background-image: url(../res/bg.gif); background-repeat: repeat-x; }'."\n";
echo '</style>'."\n";

if(isset($_GET["event"])) $event = $_GET["event"];
if(isset($_GET["big"])) $big = $_GET["big"];
if(!empty($event)) {
	//event vorhanden
	//Dateieinlesen
	$a = 0;
	$handle=opendir($event.'/thumbs/'); // das thumb verzeichnis wird eingelesen
	while ($file = readdir ($handle)) {  // die daten werden per schleife in das array bild eingelesen
	        if ($file != "." && $file != ".." && $file != "index.php") {
	                $bild[$a] = $file;
	        }
	        $a++;
	}
	sort ($bild); // das array wird sortiert
	//end Dateieinlesen

	if (!isset($big)) {
	//Bilderübersicht in den Alben
	        echo '<title>'.$websitename.' - Galerie - '.ucwords(filename($event)).'</title>'."\n";
	        echo '</head>'."\n";
	        echo '<body id="body">'."\n";
	        echo '<div style="margin-left:auto; margin-right:auto; padding-bottom:10px; text-align:center;">'."\n";
	        echo '<table style="height:54px;" align="center" cellspacing="0" cellpadding="0" border="0">'."\n";
	        echo '<tr><td>'."\n";
	        //Menüleiste
	        echo '<table style="width:1016px;" align="center" cellspacing="0" cellpadding="0" border="0">'."\n";
	        echo '<tr>'."\n";
	        echo '<td style="width:20px;">'."\n";
	        echo '  <img style="border:0;" src="../res/hdr_left.gif" width="20" height="31" alt="" /></td>'."\n";
	        echo '<td style="text-align:left; background:transparent url(../res/hdr_mid.gif); background-repeat: repeat-x; white-space:nowrap;" class="title"> <a href="../index.php">'.$websitename.'</a> - <a href=index.php>Galerie</a> - '.ucwords(filename($event)).'</td>'."\n";
	        echo '<td style="width:20px;">'."\n";
	        echo '  <img style="border:0;" src="../res/hdr_right.gif" width="20" height="31" alt="" /></td>'."\n";
	        echo '</tr></table>'."\n";
	        echo '</td></tr></table>'."\n";

	        echo '<br />'."\n";
	        echo '<table style="width:1016px;" align="center" class="infotable" cellspacing="0" cellpadding="2">'."\n";
	        echo '<tr><td align="center" class="comment">'.ucwords(filename($event)).'</td></tr>'."\n";
	        echo '</table><br />'."\n";

	        //Thumbnail images
	        echo '<table align="center" cellspacing="6" cellpadding="0" border="0">'."\n";
	        $num=0;
	        $n=1;
	        //while (list($key, $val) = each($bild)) {
			foreach ($bild as $key => $val) {
	                if ($n==1) {
	                        echo '<tr>';
	                }
	                echo '<td style="vertical-align:top; text-align:center;"><table width="266" align="center" border="0" cellspacing="0" cellpadding="0">'."\n";
	                echo '<tr><td style="width:266px; height:266px; margin-left:auto; margin-right:auto; text-align:center;" class="thumb">'."\n";
	                echo "<a href=\"index.php?event=".$event."&amp;big=".$key."\"><img class=\"image\" src='".$event."/thumbs/".$val."' alt=\"\" /></a></td></tr>\n";
	                echo '</table>'."\n";
	                echo '<div style="width:246px; padding:10px; overflow:hidden; text-align:center;" class="smalltxt">'."\n";
	                echo new_picture($image.$event."/".$val);
	                echo '</div>'."\n";
	                if ($n==4) {
	                        echo '</td></tr>'."\n\n";
	                        $n=0;
	                }
	                else {
	                        echo '</td>'."\n\n";
	                }
	                $n++;
	                $num++;
	        }
	        echo '</tr></table><br/>'."\n";
	        echo "</div>";
			//Text unterm Bild
			echo "<div align=\"center\"><a rel=\"license\" href=\"https://creativecommons.org/licenses/by-nc-nd/3.0/de/deed.de\" target=\"_blank\"><img alt=\"CC-BY-ND-NC 3.0\"  style=\"border-width:0\" src=\"https://i.creativecommons.org/l/by-nc-nd/3.0/de/80x15.png\" /></a></div><br/>\n";
			echo "<table align=\"center\" style=\"width:1016px;\" class=\"infotable\" cellspacing=\"0\" cellpadding=\"2\">\n";

			echo "<tr><td style=\"text-align:center;\" class=\"xsmalltxt\"><b>Fotograf:</b> ";
			if ($event=="tuerkei_2011") {
				echo "Henning Scholland und Benjamin Sch&uuml;tze";
			}
			else {
				echo "Henning Scholland";
			}
			echo "</td></tr>"."\n";

	        //Text unterm Bild
	}//END Bilderübersicht in den Alben

	if (isset($big)) {
	//  grosse Bilder werden ausgegeben
	         $result = count ($bild);        //Gesamtmenge des Arrays
	         settype($big,"integer");        //bildnummer als integer, nicht unbedingt nötig
	         $zurueck = $big - 1;            //vorheriges Bild
	         $vor = $big + 1;                //naechstes Bild

	//--Seitenausgabe------------------------------------------------------------------

	         echo '<title>'.$websitename.' - Galerie - '.ucwords(filename($event)).'</title>'."\n";

	         //Erstellen der Grafiken für mouseover-Effekt
	         echo "<script type=\"text/javascript\">\n";
	         echo "next0 = new Image(31,31);next0.src = \"../res/next.gif\";\n";
	         echo "next1 = new Image(31,31);next1.src = \"../res/next1.gif\";\n";
	         echo "prev0 = new Image(31,31);prev0.src = \"../res/prev.gif\";\n";
	         echo "prev1 = new Image(31,31);prev1.src = \"../res/prev1.gif\";\n";
	         echo "function makeheight() {\n";
			 echo "document.getElementById(\"bbild\").style.maxHeight=window.innerHeight+\"px\";\n";
			 echo "document.getElementById(\"bbild\").src=\"".$event."/".$bild[$big]."\";\n";
			 echo "}\n";
			 echo "</script>\n<style>\n";
	         echo "#imagemap { position:relative; }\n";
	         echo "#imagemap a span { display:none }\n";
	         echo "#imagemap a#shape1 { position:absolute; width:50%; height:100%; top:0; left:0 }\n";
	         echo "#imagemap a#shape2 { position:absolute; width:50%; height:100%; top:0; right:0 }\n";
	         echo "</style>\n";
	         echo "</head>\n";
	         echo "<body id=\"body\" onload=\"makeheight()\">\n";
	         echo "<div style=\"margin-left:auto; margin-right:auto; padding-bottom:10px; text-align:center;\">\n";
	         echo "<table style=\"height:54px;\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
	         echo "<tr><td>\n";

	         //Menüleiste
	         echo "<table style=\"width:1016px;\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
	         echo "<tr>\n";
	         echo "<td style=\"width:20px;\">\n";
	         echo "  <img style=\"border:0;\" src=\"../res/hdr_left.gif\" width=\"20\" height=\"31\" alt=\"\" /></td>\n";
	         echo "<td style=\"text-align:left; background:transparent url(../res/hdr_mid.gif); background-repeat: repeat-x; white-space:nowrap;\" class=\"title\"> <a href=\"../index.php\">".$websitename."</a> - <a href=\"index.php\">Galerie</a> - <a href=\"index.php?event=".$event."\">".ucwords(filename($event))."</a></td>\n";
	         echo "<td style=\"width:20px;\">\n";
	         echo "  <img style=\"border:0;\" src=\"../res/hdr_right.gif\" width=\"20\" height=\"31\" alt=\"\" /></td>\n";
	         echo "<td style=\"width:31px;\">\n";// vorheriges Bild
	         if($zurueck >= 0) {
	         	echo "<a href=\"index.php?event=".$event."&amp;big=".$zurueck."\"><img style=\"border:0;\" src=\"../res/prev.gif\" onmouseover=\"this.src=prev1.src\" onmouseout=\"this.src=prev0.src\" width=\"31\" height=\"31\" title=\" Voriges Bild \" alt=\"Prev\" id=\"prev\" /></a></td>\n";
	         }
	         else {
	         	echo "<img style=\"border:0;\" src=\"../res/prev_disabled.gif\" width=\"31\" height=\"31\" alt=\"Prev\" title=\" Zur ersten Seite \" /></td>\n";
	         }
	         echo "<td style=\"width:31px;\">\n";//naechstes Bild
	         if($vor < $result) {
	         	echo "<a href=\"index.php?event=".$event."&amp;big=".$vor."\"><img style=\"border:0;\" src=\"../res/next.gif\" onmouseover=\"this.src=next1.src\" onmouseout=\"this.src=next0.src\" width=\"31\" height=\"31\" title=\" Nächstes Bild \" alt=\"Next\" id=\"next\" /></a></td>\n";
	         }
	         else {
	         	echo "<img style=\"border:0;\" src=\"../res/next_disabled.gif\" width=\"31\" height=\"31\" alt=\"Next\" title=\" Zur letzten Seite \" /></td>\n";
	         }
	         echo "</tr></table>\n";
	         echo "</td></tr></table>\n";

	         echo "<br />\n";
	         echo "<table style=\"width:1016px;\" align=\"center\" class=\"infotable\" cellspacing=\"0\" cellpadding=\"2\">\n";
	         echo "<tr><td align=\"center\" class=\"comment\">".ucwords(filename($event))."</td></tr>\n";
	         echo "</table><br />\n";

	         //Bilderspalte links des Bildes

	         $numPIC=4; //Anzahl der Vorschaubilder

	         echo "<table align=\"center\"><tr>\n";

	         $lauf = $numPIC - 1;
	         while ($lauf > -1) {
	                 if (($big-$lauf-1) >= 0) {
	                        echo "<td style=\"text-align:center; padding:2px; width:56px; height:56px; border:0px;\" class=\"thumb\">";
	                        echo "<a href=\"index.php?event=".$event."&amp;big=".($big-$lauf-1)."\">";
	                        echo "<img src=\"".$event."/thumbs/".$bild[$big-$lauf-1]."\" style=\"max-width:50px; max-height:50px\" class=\"mthumb\" alt=\"\" />";
	                        echo "</a></td>\n";
	                 }
	                 else {
				     	    echo "<td style=\"text-align:center; width:50px; height:50px; border:0px;\" class=\"thumb\"></td>\n";
	                 }
	                 $lauf--;
	         }

	         echo "<td style=\"text-align:center; width:490px; height:50px; border:0px;\">";
	         echo "<a href=\"javascript:void(0)\" onclick=\"document.getElementById('bbild').style.maxHeight='1000px';\"><img src=\"../../res/lupe.png\" border=\"0\" alt=\"\" title=\"\"></a>";
	         echo "</td>\n";

			 //Bilderspalte rechts des Bildes

			 $lauf =0;
			 while ($lauf < $numPIC) {
					 if (($big+$lauf+1) < $result) {
							$rightbild[$lauf] = $bild[$big+$lauf+1];
							echo "<td style=\"text-align:center; padding:2px; width:56px; height:56px; border:0px;\" class=\"thumb\">";
							echo "<a href=\"index.php?event=".$event."&amp;big=".($big+$lauf+1)."\">";
							echo "<img src=\"".$event."/thumbs/".$bild[$big+$lauf+1]."\" style=\"max-width:50px; max-height:50px\" class=\"mthumb\" alt=\"\" />";
							echo "</a></td>\n";
					 }
					 else {
					 	    echo "<td style=\"text-align:center; width:50px; height:50px; border:0px;\" class=\"thumb\"></td>\n";
					 }
					 $lauf++;
	         }

	 		 echo "</tr></table><br/>\n";

	         //grosses Bild ausgeben

			 echo "<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>\n";

			 echo "<div id=\"imagemap\">\n";
	         //echo "<img src=\"".$event."/".$bild[$big]."\" style=\"max-width:100%\" alt=\"\" title=\"\" />";

	         echo "<img src=\"\" style=\"max-width: 100%;\" alt=\"\" title=\"\" id=\"bbild\"><noscript><img src=\"".$event."/".$bild[$big]."\" style=\"max-width: 100%;\" alt=\"\" title=\"\"></noscript>\n";
	         if ($big!=0) {
	         	echo "<a href=\"index.php?event=".$event."&amp;big=".($big-1)."\" id=\"shape1\" title=\"Zurück\" onfocus=\"this.blur()\"></a>\n";
	         }
	         if ($big!=($result-1)) {
		         echo "<a href=\"index.php?event=".$event."&amp;big=".($big+1)."\" id=\"shape2\" title=\"Weiter\" onfocus=\"this.blur()\"></a>\n";
		     }
	         echo "</div>\n";
			 echo "</tr></table>\n";
	         echo "</div>\n<br/>";

	         //Text unterm Bild
			 echo "<div align=\"center\"><a rel=\"license\" href=\"https://creativecommons.org/licenses/by-nc-nd/3.0/de/deed.de\" target=\"_blank\"><img alt=\"CC-BY-ND-NC 3.0\"  style=\"border-width:0\" src=\"https://i.creativecommons.org/l/by-nc-nd/3.0/de/80x15.png\" /></a></div><br/>\n";
			 echo "<table align=\"center\" style=\"width:1016px;\" class=\"infotable\" cellspacing=\"0\" cellpadding=\"2\">\n";

			 echo "<tr><td style=\"text-align:center;\" class=\"xsmalltxt\"><b>Fotograf:</b> ";
			 if ($event=="tuerkei_2011") {
			 	echo "Henning Scholland und Benjamin Sch&uuml;tze";
			 }
			 else {
			 	echo "Henning Scholland";
			 }
			 echo "</td></tr>"."\n";



	//--Ende Seitenausgabe------------------------------------------------------------------
	         // End grosse Bilder werden ausgegeben
	         }
	}
else {
// Albenübersicht (Startseite) ausgeben
	$handle =opendir('.'); // ordner mit kategorien öffnen
	$b = 0;
	while ($file = readdir ($handle)) {
		if ($file != "." && $file != ".." && $file != "res" && $file != "data") { // ausschließen von ordnern die keine galerien sind
			if (is_dir($file)) {
					$ordner[$b] = $file; // Ordner in Array schreiben
					//Vorschaubilder zufällig in Array schreiben
					$handle2 = opendir($ordner[$b].'/thumbs/');
					while(($file2 = readdir($handle2)) OR ($b_jpg==1)) {
						if(stristr($file2,"jpg")) {
							$vorschaubilder[$b] = $ordner[$b]."/thumbs/".$file2;
						}
					}
	        		$b++;
	        }
		} //end if
	}//end while
	//Arrays alphabetisch sortieren
	sort($ordner, SORT_STRING);
	sort($vorschaubilder, SORT_STRING);

//--Seitenausgabe------------------------------------------------------------------
	echo '<title>'.$websitename.' - Galerie</title>'."\n";
	echo "</head>\n";
	echo '<body id="body">'."\n";
	echo '<div style="margin-left:auto; margin-right:auto; padding-bottom:10px; text-align:center;">'."\n";
	echo '<table style="height:54px;" align="center" cellspacing="0" cellpadding="0" border="0">'."\n";
	echo '<tr><td>'."\n";

	echo '<table style="width:1016px;" cellspacing="0" cellpadding="0" border="0">'."\n";
	echo '<tr>'."\n";

	echo '<td style="width:20px;">'."\n";
	echo '  <img style="border:0;" src="../res/hdr_left.gif" alt="" /></td>'."\n";
	echo '<td style="text-align:left; background:transparent url(../res/hdr_mid.gif) repeat-x; white-space:nowrap;" class="title"><a href="../index.php">'.$websitename.'</a> - Galerie</td>'."\n";
	echo '<td style="width:20px;">'."\n";
	echo '  <img style="border:0;" src="../res/hdr_right.gif" alt="" /></td>'."\n";

	echo '</tr></table>'."\n";
	echo '</td></tr></table>'."\n";
	echo '<br />'."\n";

        	//Thumbnail images
        	echo '<table align="center" cellspacing="6" cellpadding="0" border="0">'."\n";
        	$num=0;
        	$n=1;
	//while (list($key, $val) = each($ordner)) {
	foreach ($ordner as $key => $val) {
                 if ($n==1) {
                        echo '<tr>';
		}
		echo '<td style="vertical-align:top; text-align:center;"><div style="width:100%; height:20px;"></div><table width="100" align="center" border="0" cellspacing="0" cellpadding="0">'."\n";
	        echo '<tr><td style="height:100px; background:url(../res/folder1.gif); background-repeat:no-repeat; vertical-align:top;">'."\n";
	        echo '<table style="width:78px; height:80px; margin-right:0px; margin-left:auto; border:0;"><tr><td style="text-align:center;"><a href="index.php?event='.$val.'"><img class="mthumb" src="'.$vorschaubilder[$key].'" style="max-width:60px; max-height:60px" alt=""/></a></td></tr>'."\n";
	        echo '</table></td></tr>'."\n";
	        echo '</table>'."\n";
	        echo '<div style="width:150px; padding:10px; overflow:hidden; text-align:center;" class="smalltxt">'."\n";

		$a = 0;
	        $newpic=0;
	        $handle=opendir($val.'/thumbs/'); // das thumb verzeichnis wird eingelesen
	        while ($file = readdir ($handle)) {  // die daten werden per schleife in das array bild eingelesen
			if ($file != "." && $file != ".." && $file != "index.php") {
				if (new_picture($bild[$a] = $val.'/'.$file) == '<span class="newlabel">&nbsp;NEU&nbsp;</span>'."\n") {
					$newpic++;
				}
	                }
			$a++;
	        }
	        if ($newpic > 0) {
			echo '<span class="newlabel">&nbsp;NEU&nbsp;</span>'."\n";
	        }

	        echo '<a href="index.php?event='.$val.'">'.ucwords(filename($val)).'</a>';
	        echo '</div>'."\n";
                	if ($n==5) {
                 	echo '</td></tr>'."\n\n";
                        	$n=0;
                	}
                	else {
                 	echo '</td>'."\n\n";
                	}
                	$n++;
                	$num++;
        }
        echo '</tr></table><br />'."\n";
        echo "</div>\n";

		//Text unterm Bild
		echo "<div align=\"center\"><a rel=\"license\" href=\"https://creativecommons.org/licenses/by-nc-nd/3.0/de/deed.de\" target=\"_blank\"><img alt=\"CC-BY-ND-NC 3.0\"  style=\"border-width:0\" src=\"https://i.creativecommons.org/l/by-nc-nd/3.0/de/80x15.png\" /></a></div><br/>\n";
		echo "<table align=\"center\" style=\"width:1016px;\" class=\"infotable\" cellspacing=\"0\" cellpadding=\"2\">\n";

//--END Seitenausgabe------------------------------------------------------------------
//END Albenübersicht (Startseite) ausgeben
}


if (!empty($event) && isset($big)) {
	echo "<tr><td style=\"text-align:center;\" class=\"smalltxt\">";
    read_exif($event."/".$bild[$big]);      //Bildinformationen
    echo "</td></tr>\n";
}
echo "<tr><td style=\"text-align:center;\" class=\"xsmalltxt\"><a href=\"../index.php?event=impressum\">Impressum\Kontakt</a> | <a href=\"index.php?event=privacy\">Datenschutzerklärung</a> | <a href=\"../index.php?event=disclaimer\">Disclaimer</a></td></tr>"."\n";
echo "</table><br/><br/><br/>\n";
echo "</body>\n</html>\n";
?>