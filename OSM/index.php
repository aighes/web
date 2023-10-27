<?php
// Set up default timezone.
date_default_timezone_set('Europe/Berlin');
function datum($file) {
	$lines = file("date", FILE_IGNORE_NEW_LINES);
	$dbdate = $lines[count($lines)-1];
	$filetime = filectime($file);
	$filedate = mktime(5, 0, 0, date("m",$filetime), date("d",$filetime), date("Y",$filetime));
	$heute = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
	$jetzt = time();
	$heute_5 = mktime(5, 0, 0, date("m"), date("d"), date("Y"));
	$filedate_7 = mktime(7, 0, 0, date("m",$filetime), date("d",$filetime), date("Y",$filetime));

	$showdate=$dbdate;

	if ($filetime > $dbdate) {
		$fp = fopen('date', 'a+');
		fwrite($fp, $filetime."\n");
		fclose($fp);
		$showdate=$filedate;
	}

	return date("d.m.Y", $showdate);
}


$url=$_SERVER['HTTP_HOST'];
$websitename = str_replace("www.","", $url);

$lang = "de";
if(isset($_GET["lang"])) $lang = $_GET["lang"];

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />'."\n";
echo '<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.5)" />'."\n";
echo '<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.5)" />'."\n";
echo '<link rel="stylesheet" type="text/css" href="../res/styles.css" />'."\n";
echo '<title>'.$websitename.' - RadReiseKarte</title>'."\n";

//Erstellen der Grafiken für mouseover-Effekt
echo '<script type="text/javascript">'."\n";
echo 'up0 = new Image(31,31); up0.src = "../res/up.gif";'."\n";
echo 'up1 = new Image(31,31); up1.src = "../res/up1.gif";'."\n";
echo '</script>'."\n";
echo '<script type="text/javascript" src="../res/jquery.min.js"></script>'."\n";
echo '<script type="text/javascript" src="../res/slimbox2.js"></script>'."\n";

echo '<link rel="stylesheet" type="text/css" href="../res/styles.css" />'."\n";
echo '<style type="text/css">'."\n";
echo 'body { background-image: url(../res/bg.gif); background-repeat: repeat-x; }'."\n";
echo '</style>'."\n";
echo '</head>'."\n";

echo '<body id="body">'."\n";
echo '<div style="margin-left:auto; margin-right:auto; padding-bottom:10px; text-align:center;">'."\n";
echo '<table style="height:54px;" align="center" cellspacing="0" cellpadding="0" border="0">'."\n";
echo '<tr><td>'."\n";

echo '<table style="width:1016px;" cellspacing="0" cellpadding="0" border="0">'."\n";
echo '<tr>'."\n";

echo '<td style="width:20px;">'."\n";
echo '  <img style="border:0;" src="../res/hdr_left.gif" alt="" /></td>'."\n";
echo '<td style="text-align:left; background:transparent url(../res/hdr_mid.gif) repeat-x; white-space:nowrap;" class="title"><a href="../index.php">'.$websitename.'</a> - RadReiseKarte</td>'."\n";
echo '<td style="width:20px;">'."\n";
echo '  <img style="border:0;" src="../res/hdr_right.gif" alt="" /></td>'."\n";
echo "<td style=\"width:31px;\">\n";// Sprachenflagge
if ($lang=="de") {
	echo "<a href=\"index.php?lang=en\"><img style=\"border:0;\" src=\"../res/en.png\" title=\"english version\" alt=\"en\"/></a>";
}
if ($lang=="en") {
	echo "<a href=\"index.php?lang=de\"><img style=\"border:0;\" src=\"../res/de.png\" title=\"deutsche Version\" alt=\"de\"/></a>";
}
echo "</td></tr></table>\n";
echo "</td></tr></table>\n";

if ($lang=="de"){
	echo "<h1><b><u>OSM-basierte Karten für Garmin GPS-Geräte</u></b></h1>\n";
}
if ($lang=="en"){
	echo "<h1><b><u>OSM based maps for Garmin GPS devices</u></b></h1>\n";
}

echo "<table align=\"center\"><tr valign=\"top\"><td width=\"776\" align=\"left\">\n";
if ($lang=="de"){
	echo 'Neben einer zu topografischen Karte passenden Landschaftsdarstellung, findet ihr in dieser Karte Infos zu Unterkünften (Hotel, Hostel, Bed&amp;Breakfast, Zelt), zu diversen Einkaufsmöglichkeiten (besonders Radgeschäfte), zu Ärzten, Krankenhäusern, etc., zu Restaurants &amp; Co und zu Transportmöglichkeiten. Desweitern werden die Wege abseits der Straßen nach ihrer Beschaffenheit und Eignung fürs Radfahren mit einem Trekkingrad/Reiserad unterschieden. Kopfsteinpflaster wird auf allen Wegen gekennzeichnet.<br/><br/>'."\n";
	echo "Erstellt wurden die Karten aus den Daten von <a href=\"http://www.openstreetmap.org\" target=\"_blank\">OpenStreetMap</a><br/><br/>\n";
	echo "<b><u>Installation der gmapsupp.img</u></b><br/>Die jeweilige Karte liegt bereits als <b>gmapsupp.img</b> vor und muss in den Unterordner ...\\Garmin\\ entpackt werden. Nach Möglichkeit sollte die Karte auf einer externen Speicherkarte abgelegt werden und nicht in den Hauptspeicher des GPS-Gerätes.<br/><br/>\n";
	echo "<b><u>Installation für BaseCamp/MapSource</u></b><br/>Für die Nutzung in BaseCamp oder MapSource empfiehlt sich das Setup herunterzuladen. Das Archiv muss in das Garmin-Kartenverzeichnis entpackt werden. Dieses findet sich bspw. unter C:\ProgramData\Garmin\Maps.<br/><br/>\n";
	echo "Die Karten wurden von mir getestet. Die Benutzung erfolgt jedoch immer auf eigene Gefahr.<br/><br/>\n";
	echo "<u><b>Routing</b></u><br/>Das Routing ist für eine Fortbewegung auf dem Fahrrad ausgelegt. Eine Verwendung mit anderen Verkehrsmitteln ist nicht vorgesehen und auch nicht ratsam. Gute Ergebnisse liefert das Autorouting, wenn man den Routingmodus auf 'Auto/Motorrad' stellt. Autobahnen sollten erlaubt werden. Der Schalter 'unbefestigte Wege' vermeidet das Routing auf unbefestigten Wegen. Über den Regler 'Mautstraßen' können autobahnähnliche Straße vermieden werden.<br/>Die durch das Autorouting erstellte Strecke stellt lediglich einen Streckenvorschlag dar und muss an die jeweilige Situation vor Ort angepasst werden.<br/><br/>\n";
}
if ($lang=="en") {
	echo "In addition to a coherent representation of the landscape that is part of a topographical map, you'll find in this map information about accommodation (hotel, hostel, bed&amp;breakfasts, tent), various shops (especially bicycle shops), doctors, hospitals, restaurants and transport facilities. Also used to distinguish the way off the streets according to their composition and suitability for cycling with a trekking or touring bike. Cobblestones will be marked on any road.<br/><br/>\n";
	echo "The maps were created from data of <a href=\"http://www.openstreetmap.org\" target=\"_blank\">OpenStreetMap</a><br/><br/>\n";
	echo "<b><u>Installation as gmapsupp.img</u></b><br/>The maps are already available as <b>gmapsupp.img</b> and must be extracted to the subfolder ... \\Garmin\\. If possible, the map should be stored on an external memory card and not in the main memory of the GPS device.<br/><br/>\n";
	echo "<b><u>Installation for BaseCamp/MapSource</u></b><br/>For using the maps with BaseCamp or MapSource download the Setup and extract it to one of the Garmin Map directories, like C:\ProgramData\Garmin\Maps.<br/><br/>\n";
	echo "The maps were tested by me. Every usage is on your own risk.<br/><br/>\n";
	echo "<u><b>Routing</b></u><br/>The routing is designed to travel on a bike. Any use by other modes is not intended and not even advisable. Good results are provided by the auto-routing if you set the routing mode to 'Auto / Motorcycle'. Highways should be allowed. The switch 'dirt roads' avoids the routing on trails, with 'toll' you can switch off usage of important roads.<br/>The route created by auto-routing represents only a proposal route and must be adapted to the situation.<br/><br/>\n";
}
echo "<br/>\n";

$offline=0;
if ($offline==1)
{
	if ($lang=="de") {
		echo "<font color=#FF0000>Wegen Urlaub erfolgt das nächste Update erst im April</font><br/><br/>\n";
	}
	if ($lang=="en") {
		echo "<font color=#FF0000>Due to vacation the next update is not until April</font><br/><br/>\n";
	}
}
echo "<br/>\n";
echo "<table align=\"center\">";
echo "<td style=\"vertical-align:top;\"><a href=\"legende_de.png\" rel=\"lightbox\" title=\"Legende\"><img src=\"legende_de.png\" height=\"200px\" border=\"0\" alt=\"\" title=\"\"/></a></td>\n";
echo "<td width=\"50\"></td>\n";
echo "<td valign=\"top\">\n";

echo "<table>\n";

$handle =opendir('data'); // ordner mit kategorien öffnen
$b = 0;
$c = 0;
while ($file = readdir ($handle)) {
	if ($file != "." && $file != "..") { // ausschließen von ordnern und Dateien
		if (strstr($file,"MS_")){
		//	$ordnerMS[$c] = $file;
		//	$c++;
		}
		else {
			$ordner[$b] = $file; // Ordner in Array schreiben
			$b++;
		}
	} //end if
}//end while
closedir($handle);//Ordner schließen

if ($b>0) {
	//Arrays alphabetisch sortieren
	sort($ordner, SORT_STRING);
	//sort($ordnerMS, SORT_STRING);
	$n=0;
	$fdate = datum("data/".$ordner[$n]);

	//while (list($key, $val) = each($ordner)) {
	foreach ($ordner as $key => $val) {
		$link_name = substr($ordner[$n], 0, strrpos($ordner[$n], "."));
		echo "<tr><td>".$link_name."</td>";
		echo "<td> ( <a href=\"../OSM/data/".$ordner[$n]."\" target=\"_blank\" >gmapsupp.img</a> ) </td>";
		echo "<td> ( <a href=\"../OSM/data/MS_".$ordner[$n]."\" target=\"_blank\" >Setup</a> ) </td>";
		echo "<td>".$fdate."</td></tr>\n";
		$n++;
	}
}
else {
	$lines = file("date", FILE_IGNORE_NEW_LINES);
	$fdate = date("d.m.Y", $lines[count($lines)-1]);
}

echo "</table>\n";
echo "</td></tr></table><br/>\n";
echo "</td><td width=\"240\"><img src=\"map_screen.png\" alt=\"\" /></td></tr></table>\n";

if ($lang=="de") {
	echo "<br/>Die auf dieser Seite angebotene Bilder stehen unter <a href=\"http://creativecommons.org/licenses/by-sa/2.0/de/deed.de\" target=\"_blank\">CC-BY-SA 2.0</a>\n";
	echo "<br/>Die auf dieser Seite zum Herunterladen angebotene Garminkarten wurden aus Daten von <a href=\"http://www.openstreetmap.org\" target=\"_blank\">OpenStreetMap</a> erstellt und stehen unter <a href=\"http://opendatacommons.org/licenses/odbl/\" target=\"_blank\">ODbL</a>.<br/>\n";
	echo "Der <a href=\"https://github.com/aighes/RadReiseKarte\" target=\"_blank\">mkgmap-style</a> steht unter <a href=\"http://creativecommons.org/licenses/by/2.0/de/deed.de\" target=\"_blank\">CC-BY 2.0</a><br/>\n";
}
if ($lang=="en") {
	echo "<br/>Pictures offered on this page are licensed under <a href=\"http://creativecommons.org/licenses/by-sa/2.0/de/deed.en\" target=\"_blank\">CC-BY-SA 2.0</a>\n";
	echo "<br/>Maps for Garmin devices offered on this page are generated by data provided by <a href=\"http://www.openstreetmap.org\" target=\"_blank\">OpenStreetMap</a> and is licensed under <a href=\"http://opendatacommons.org/licenses/odbl/\" target=\"_blank\">ODbL</a>.<br/>\n";
	echo "<a href=\"https://github.com/aighes/RadReiseKarte\" target=\"_blank\">Mkgmap-style</a> is released under <a href=\"http://creativecommons.org/licenses/by/2.0/de/deed.en\" target=\"_blank\">CC-BY 2.0</a><br/>\n";
}
echo "</div>\n";
echo '<table align="center" style="width:1016px;" class="infotable" cellspacing="0" cellpadding="2">';
echo '<tr><td style="text-align:center;" class="xsmalltxt"><a href="../index.php?event=impressum">Impressum\Kontakt</a> | <a href="index.php?event=privacy">Datenschutzerklärung</a> | <a href="../index.php?event=disclaimer">Disclaimer</a></td></tr>';
echo "</table>\n";
echo "<br/><br/><br/>\n";
echo "</body>\n";
echo "</html>\n";
?>
