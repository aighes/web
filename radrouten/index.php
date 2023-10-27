<?php
$url=$_SERVER['HTTP_HOST'];
$websitename = str_replace("www.","", $url);

function getlatlon($quelle, $suche) {//Funktion zum Auslesen von lat und lon aus der gpx-Datei
	$suche= " ".$suche."=\"";
	if (strpos($quelle, $suche) == false){
		$suche = str_replace("\"","'",$suche);
	}//end if
	$quelle = substr($quelle, strpos($quelle, $suche)+ strlen($suche));
	return str_replace(",",".",substr($quelle, 0, strpos($quelle, "\"")));
}//end function
function getele($quelle) {//Funktion zum Auslesen von ele aus der gpx-Datei
	$quelle = substr($quelle, strpos($quelle, "<ele>")+ strlen("<ele>"));
	return str_replace(",",".",substr($quelle, 0, strpos($quelle, "</ele>")));
}//end function
function trackname($name) {
	$name = substr($name, 0, strlen($name) - 4);
	$name = str_replace("_", " ", $name);
	$name = str_replace("ae", "ä", $name);
	$name = str_replace("oe", "ö", $name);
	$name = str_replace("-", " - ", $name);
	return str_replace("ue", "ü", $name);
}//end function
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de-de">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="Description" content="Radroute" />
<link rel="stylesheet" type="text/css" href="../res/styles.css" media="screen" />
<link rel="stylesheet" href="../res/leaflet.css" />
<!--[if lte IE 8]>
     <link rel="stylesheet" href="../res/leaflet.ie.css" />
<![endif]-->
<?php
echo "<title>".$websitename." - Radroute</title>\n";
?>
<script type="text/javascript">//Erstellen der Grafiken für mouseover-Effekt
	up0 = new Image(31,31); up0.src = "../res/up.gif";
	up1 = new Image(31,31); up1.src = "../res/up1.gif";
</script>
<script type="text/javascript" src="../res/jquery.min.js"></script>
<script type="text/javascript" src="../res/slimbox2.js"></script>
<script type="text/javascript" src="../res/GPX.js"></script>
<script type="text/javascript" src="../res/leaflet.js"></script>
<script type="text/javascript" src="../../res/layer/vector/GPX.js"></script>
<script type="text/javascript" src="../../res/control/Scale.js"></script>
<?php
if(isset($_GET["track"])){
	$track_name = $_GET["track"];//Dateiname des gpx-Track
	$track = "gpx/".$track_name; // erstellt die URL des Tracks aus dem Unterordner gpx
	$track_filename = $track_name;
	$track_name = trackname($track_name);
	$track_title = ": ".$track_name;
	if (file_exists($track)) {//prüfen, ob angegebene Datei vorhanden ist

		 //Koordinaten und Höhen in Array schreiben
		$fp = fopen( $track, "r"); // gpx-Datei öffnen
		$n=0;
		$m=0;
		$k=0;
		$up=0.0;
		$down=0.0;
		$laenge = 0.0;
		while (! feof( $fp )) {
			$zeile  = fgets( $fp , 4096);
			if (strpos($zeile,"<trkpt") !== false) {
				$lat[$n] = getlatlon($zeile, "lat");
				$lon[$n] = getlatlon($zeile, "lon");
				$lat_m[$k] = $lat[$n];
				$lon_m[$k] = $lon[$n];
				$k++;
				$n++;
			} //end if
			if (strpos($zeile,"<ele>") !== false) {
				$ele[$m] = getele($zeile);
				$m++;
			}//end if
			if (strpos($zeile,"</trkseg>") !== false) {
				//Berechnung der Tracklänge
				$i = 0;
				$r0 = 6371.0;//Erdradius
				while ($i < ($n-1)) {
					if(($lat[$i] != $lat[$i+1]) && ($lon[$i] != $lon[$i+1])) {
						$a = (90.0 - $lat[$i]) * M_PI / 180.0;
						$b = (90.0 - $lat[$i+1]) * M_PI / 180.0;
						$gamma = (abs($lon[$i+1] - $lon[$i])) * M_PI / 180.0;
						$c = $r0 * acos(cos($a)*cos($b) + sin($a)*sin($b)*cos($gamma));
						$laenge = $laenge + $c;
					}//end if
					$i++;
				}//end while

				//Höhenmeter addieren
				$i=0;
				while ($i < ($m-1)) {
					if ($ele[$i] < $ele[$i+1]) {
						$up = $up + $ele[$i+1] - $ele[$i];
					}//end if
					if ($ele[$i] > $ele[$i+1]) {
						$down = $down + $ele[$i] - $ele[$i+1];
					}//end if
					$i++;
				}//end while
				$n=0;
				$m=0;
			} //end if
		} //end while
		unset($lat);
		unset($lon);
		unset($ele);
		$laenge = (round(10 * $laenge) / 10)." km";
		$laenge = str_replace(".",",",$laenge);
		$up = (round(10 * $up) / 10)." m";
		$up = str_replace(".",",",$up);
		$down = -(round(10 * $down) / 10)." m";
		$down = str_replace(".",",",$down);
		$b_ele = true;
		fclose($fp); //gpx-Datei schließen

		//Marker-Positionen
		$s_lon = $lon_m[0];
		$s_lat =$lat_m[0];
		$e_lon =$lon_m[$k-1];
		$e_lat =$lat_m[$k-1];
		//Größe der angezeigten Karte
		$width=760;//Breite in pixel
		$height=600;//Höhe in pixel
		$b_track = true;
	}//end if
	else { //Datei nicht vorhanden
		$laenge = "n/a";
		$up = "n/a";
		$down = "n/a";
		$width = 760;
		$height = 600;
		$b_track = false;
		$b_ele = false;
	}//end else
}//end if
else {//kein Parameter
	$laenge = "n/a";
	$up = "n/a";
	$down = "n/a";
	$b_track = false;
	$b_ele = false;
	$track="";
	$track_title="";
}//end else

	echo "<style type=\"text/css\">\n";
	echo "  body { background-image: url(../res/bg.gif); background-repeat: repeat-x; }\n";
	echo "</style>\n";
    echo "</head>\n";
    echo "<body>\n";
//--BEGIN--Menüleiste
	echo "<table style=\"height:54px;\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
	echo "<tr><td>\n";
	echo "<table style=\"width:1016px;\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
	echo "<tr>\n";
	echo "<td style=\"width:20px;\">\n";
	echo "  <img style=\"border:0;\" src=\"../res/hdr_left.gif\" width=\"20\" height=\"31\" alt=\"\" /></td>\n";
	echo "<td style=\"text-align:left; background:transparent url(../res/hdr_mid.gif); background-repeat: repeat-x; white-space:nowrap;\" class=\"title\"><a href=\"../index.php\">".$websitename."</a> - Radroute".$track_title."</td>\n";
	echo "<td style=\"width:20px;\">\n";
	echo "  <img style=\"border:0;\" src=\"../res/hdr_right.gif\" width=\"20\" height=\"31\" alt=\"\" /></td>\n";
	echo "</tr></table>\n";
	echo "</td></tr></table>\n";
//--END--Menüleiste
		echo "<table align=\"center\" style=\"vertical-align:top;\">";
		echo "<tr>";
		echo "<td height=\"800\" width=\"316\">\n";
	        echo "<table align=\"center\" style=\"vertical-align:top;\">";
	        echo "<tr>";
	        echo "<td height=\"690\" width=\"316\" align=\"left\" valign=\"top\">\n";
	        echo "<div style=\"width:316px;height:690px;overflow:auto\">\n";
	        $handle =opendir('gpx'); // ordner mit kategorien öffnen
	        $b = 0;
	        while ($file = readdir ($handle)) {
	                if ($file != "." && $file != ".." && $file != "privat") { // ausschließen von ordnern und Dateien
				$temp[$b] = $file;
				$b++;
			}//end if
	     	}//end while
	     	sort($temp);
	     	$c = 0;
	     	while ($c < $b) {
				if (strcmp("./gpx/".$temp[$c], $track)==false) {
					echo "<nobr><img src=\"../res/dot.gif\" border=\"0\" alt=\"\"/><u><a href=\"./index.php?track=".$temp[$c]."\">".trackname($temp[$c])."</a></u></nobr><br/>\n";
				}//end if
				else {
					echo "<nobr><img src=\"../res/dot.gif\" border=\"0\" alt=\"\"/><a href=\"./index.php?track=".$temp[$c]."\">".trackname($temp[$c])."</a></nobr><br/>\n";
				}//end else
				$c++;
	        }//end while
	        closedir($handle);//Ordner schließen
	        echo "</div>\n</td></tr>\n<tr><td height=\"100\" width=\"316\" align=\"left\" valign=\"top\" style=\"border-color:#888888; border-width:2px; border-style:solid;\">\n";
	        echo "<u>Trackdaten:</u><br/>\n";
		echo "<table>\n<tr><td width=\"32\" valign=\"top\">\n";
		if ($b_track) {
		 	echo "<a href=\"".$track."\" target=\"_blank\"><img src=\"../res/disk.png\" border=\"0\" alt=\"\" title=\"ausgewählten GPX-Track herunterladen\"></a><br/>\n";
			if (file_exists("alt/".str_replace(".gpx",".png",$track_filename))) echo "<a href=\"alt/".str_replace(".gpx",".png",$track_filename)."\" rel=\"lightbox\" title=\"Höhenprofil ".$track_name."\" ><img src=\"../res/profil.png\" border=\"0\" alt=\"\" title=\"Höhenprofil anzeigen\"></a>\n";
	        }
	        echo" </td><td width=\"184\" valign=\"top\">\n";
				echo "<table>\n";
					echo "<tr><td width=\"84\">Tracklänge:</td><td width=\"80\" align=\"right\">".$laenge."</td></tr>\n";
					echo "<tr><td width=\"84\">Anstieg:</td><td width=\"80\" align=\"right\">".$up."</td></tr>\n";
					echo "<tr><td width=\"84\">Abstieg:</td><td width=\"80\" align=\"right\">".$down."</td></tr>\n";
				echo "</table>\n";
	         echo "</td></tr></table>";
	         echo "</td></tr></table>";
        echo "</td><td>\n";
	//DIV für das anzeigen der Karte
		echo '<div style="width:960px; height:800px" id="map"></div>'."\n";
		echo '<script type="text/javascript">'."\n";
		echo 'var osm_de = new L.TileLayer("https://tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png", {maxZoom: 18, minZoom: 1, attribution: "Map data &copy; <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\">OpenStreetMap</a> and contributors, <a href=\"http://opendatacommons.org/licenses/odbl/\" target=\"_blank\">ODbL</a>"});'."\n";
		echo 'var mapnik_osm = new L.TileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {maxZoom: 18, minZoom: 1, attribution: "Map: &copy; <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\" style=\"\">OpenStreetMap</a> contributors"});'."\n";
		echo 'var ocm = new L.TileLayer("https://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png?apikey=b1e166d52dbe4dc888e73fabd84242ae", {maxZoom: 18, minZoom: 1, attribution: "Maps &copy; <a href=\"http://www.thunderforest.com\" target=\"_blank\" style=\"\">Thunderforest</a>, Data &copy; <a href=\"http://www.openstreetmap.org/copyright\" target=\"_blank\" style=\"\">OpenStreetMap contributors</a>"});'."\n";
		
		if ($b_track == true){
			echo 'var track = new L.GPX("'.$track.'", {async: true}).on("loaded", function(e) { map.fitBounds(e.target.getBounds()); });'."\n";

			echo "var LeafIcon = L.Icon.extend({options: {iconSize: [16, 28], iconAnchor: [0, 28]}});\n";
			echo "var startIcon = new LeafIcon({iconUrl: '../res/pin_start.png'}), zielIcon = new LeafIcon({iconUrl: '../res/pin_ziel.png'});\n";
			
			echo "var markerLayer = L.layerGroup();\n";
			echo "var marker1 = L.marker([".$s_lat.", ".$s_lon."], {icon: startIcon}).addTo(markerLayer);\n";
			echo "var marker2 = L.marker([".$e_lat.", ".$e_lon."], {icon: zielIcon}).addTo(markerLayer);\n";

			echo "var map = new L.Map('map', {center: new L.LatLng(50, 10), zoom: 5, layers:[mapnik_osm, track, markerLayer]});\n";

			echo "map.addControl(new L.Control.Scale());\n";
			echo 'map.addControl(new L.Control.Layers({"OpenCycleMap":ocm, "OSM DE":osm_de, "Mapnik":mapnik_osm}, {"GPX-Track":track, "Marker":markerLayer}));'."\n";//

		}//end if
		else{
			echo "var map = new L.Map('map', {center: new L.LatLng(50, 10), zoom: 5, layers:mapnik_osm});\n";
			echo "map.addControl(new L.Control.Scale());\n";
			echo 'map.addControl(new L.Control.Layers({"OpenCycleMap":ocm, "OSM DE":osm_de, "Mapnik":mapnik_osm}));'."\n";
		}
		echo '</script>'."\n";  	 
		 
        echo "</td></tr>\n</table><br/>\n";
	echo '<table align="center" style="width:1016px;" class="infotable" cellspacing="0" cellpadding="2">';
	echo '<tr><td style="text-align:center;" class="xsmalltxt"><a href="../index.php?event=impressum">Impressum/Kontakt</a> | <a href="index.php?event=privacy">Datenschutzerklärung</a> | <a href="../index.php?event=disclaimer">Disclaimer</a></td></tr>';
	echo '</table>'."\n";
	echo '<br/><br/><br/>'."\n";
    echo "</body>\n</html>";
?>