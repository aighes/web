<?php
$url=$_SERVER['HTTP_HOST'];
$websitename = str_replace("www.","", $url);

if(isset($_GET["event"])) $event = $_GET["event"];
if(!empty($event)) {
	//event vorhanden
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
	echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">'."\n";
	echo '<head>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />'."\n";
	echo '<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.5)" />'."\n";
	echo '<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.5)" />'."\n";
	echo '<head>'."\n";
	echo '<title>'.$websitename.' - '.ucwords($event).'</title>'."\n";

	//Erstellen der Grafiken für mouseover-Effekt
	echo '<script type="text/javascript">'."\n";
	echo 'up0 = new Image(31,31); up0.src = "../res/up.gif";'."\n";
	echo 'up1 = new Image(31,31); up1.src = "../res/up1.gif";'."\n";
	echo '</script>'."\n";

	echo '<link rel="stylesheet" type="text/css" href="res/styles.css" />'."\n";
	echo '<style type="text/css">'."\n";
	echo 'body { background-image: url(res/bg.gif); background-repeat: repeat-x; }'."\n";
	echo '</style>'."\n";
	echo '</head>'."\n";
	echo '<body id="body" onload="keypresslistener();">'."\n";
	echo '<div style="width:99%; margin-left:auto; margin-right:auto; margin-bottom: 10px; text-align:center;">'."\n";
	echo '<table style="height:54px;" align="center" cellspacing="0" cellpadding="0" border="0">'."\n";
	echo '<tr><td>'."\n";
	echo '<!-- Header of index pages -->'."\n";
	echo '<table style="width:1016px;" cellspacing="0" cellpadding="0" border="0">'."\n";
	echo '<tr>'."\n";

	echo '<td style="width:31px">'."\n";
	echo '  <a href="../index.php"><img style="border:0;" src="../res/up.gif" onmouseover="this.src=up1.src" onmouseout="this.src=up0.src" width="31" height="31" title=" Eine Ebene nach oben " alt="Up" id="up" /></a></td>'."\n";
	echo '<td style="width:20px;">'."\n";
	echo '  <img style="border:0;" src="res/hdr_left.gif" alt="" /></td>'."\n";
	echo '<td style="text-align:left; background:transparent url(res/hdr_mid.gif) repeat-x; white-space:nowrap;" class="title">'.$websitename.' - Impressum/Kontakt</td>'."\n";
	echo '<td style="width:20px;">'."\n";
	echo '  <img style="border:0;" src="res/hdr_right.gif" alt="" /></td>'."\n";
	echo '</tr></table>'."\n";
	echo '</td></tr></table>'."\n";
	echo '<br/>'."\n";
	switch ($event) {
	case "impressum":
		echo '<table width="960" align="center">'."\n";
		echo '<tr>'."\n";
		echo '<td>'."\n";
		echo '<u><b>Impressum/Kontakt</b></u>'."\n";
		echo '<br/><br/><br/>'."\n";
		echo 'Alle Bilder auf dieser Website unterliegen dem Urheberrecht. Nähere Informationen zur Lizenz gibt es <a href="http://creativecommons.org/licenses/by-nc-nd/3.0/de/">hier</a>.<br/>'."\n";
		echo 'Falls Ihrerseits Interesse an einem oder mehreren Bildern besteht, können Sie sich gerne mit mir in Verbindung setzen.'."\n";

		echo "<br/><br/><br/><br/><br/><br/><br/>\n";
		echo "</td></tr></table>\n";
		echo "<table width=\"600\" align=\"center\"><tr><td width=\"300\" align=\"center\">\n";
		echo "<img src=\"res/aighes.png\" alt=\"\"/></td>\n";
		echo "<td align=\"center\"><u><i>Made by:</i></u><br/><br/>\n";
		echo "Henning Scholland<br/>";
		echo "99428 Weimar<br/><br/>";
		echo "info {at} hscholland.de<br/>";
		echo '</td>'."\n";
		echo '</tr>'."\n";
		echo '</table>'."\n";
		echo "<br/><br/><br/>\n";
		break;
	case "disclaimer":
		echo '<table align="center">'."\n";
		echo '<tr>'."\n";
		echo '<td width="960" align="center">'."\n";
		echo '    <u>1. Inhalt des Onlineangebotes</u>'."\n";
		echo '    <br/><br/>'."\n";
		echo '    Der Autor übernimmt keinerlei Gewähr für die Aktualität, Korrektheit, Vollständigkeit oder Qualität der bereitgestellten Informationen. Haftungsansprüche gegen den Autor, welche sich auf Schäden materieller oder ideeller Art beziehen, die durch die Nutzung oder Nichtnutzung der dargebotenen Informationen bzw. durch die Nutzung fehlerhafter und unvollständiger Informationen verursacht wurden, sind grundsätzlich ausgeschlossen, sofern seitens des Autors kein nachweislich vorsätzliches oder grob fahrlässiges Verschulden vorliegt. Alle Angebote sind freibleibend und unverbindlich. Der Autor behält es sich ausdrücklich vor, Teile der Seiten oder das gesamte Angebot ohne gesonderte Ankündigung zu verändern, zu ergänzen, zu löschen oder die Veröffentlichung zeitweise oder endgültig einzustellen.'."\n";
		echo '    <br/><br/><br/>'."\n";
		echo '    <u>2. Verweise und Links</u>'."\n";
		echo '    <br/><br/>'."\n";
		echo '    Bei direkten oder indirekten Verweisen auf fremde Webseiten ("Hyperlinks"), die außerhalb des Verantwortungsbereiches des Autors liegen, würde eine Haftungsverpflichtung ausschließlich in dem Fall in Kraft treten, in dem der Autor von den Inhalten Kenntnis hat und es ihm technisch möglich und zumutbar wäre, die Nutzung im Falle rechtswidriger Inhalte zu verhindern. Der Autor erklärt hiermit ausdrücklich, dass zum Zeitpunkt der Linksetzung keine illegalen Inhalte auf den zu verlinkenden Seiten erkennbar waren. Auf die aktuelle und zukünftige Gestaltung, die Inhalte oder die Urheberschaft der verlinkten/verknüpften Seiten hat der Autor keinerlei Einfluss. Deshalb distanziert er sich hiermit ausdrücklich von allen Inhalten aller verlinkten /verknüpften Seiten, die nach der Linksetzung verändert wurden. Diese Feststellung gilt für alle innerhalb des eigenen Internetangebotes gesetzten Links und Verweise sowie für Fremdeinträge in vom Autor eingerichteten Gästebüchern, Diskussionsforen, Linkverzeichnissen, Mailinglisten und in allen anderen Formen von Datenbanken, auf deren Inhalt externe Schreibzugriffe möglich sind. Für illegale, fehlerhafte oder unvollständige Inhalte und insbesondere für Schäden, die aus der Nutzung oder Nichtnutzung solcherart dargebotener Informationen entstehen, haftet allein der Anbieter der Seite, auf welche verwiesen wurde, nicht derjenige, der über Links auf die jeweilige Veröffentlichung lediglich verweist.'."\n";
		echo '    <br/><br/><br/>'."\n";
		echo '    <u>3. Urheber- und Kennzeichenrecht</u>'."\n";
		echo '    <br/><br/>'."\n";
		echo '    Der Autor ist bestrebt, in allen Publikationen die Urheberrechte der verwendeten Bilder, Grafiken, Tondokumente, Videosequenzen und Texte zu beachten, von ihm selbst erstellte Bilder, Grafiken, Tondokumente, Videosequenzen und Texte zu nutzen oder auf lizenzfreie Grafiken, Tondokumente, Videosequenzen und Texte zurückzugreifen. Alle innerhalb des Internetangebotes genannten und ggf. durch Dritte geschützten Marken- und Warenzeichen unterliegen uneingeschränkt den Bestimmungen des jeweils gültigen Kennzeichenrechts und den Besitzrechten der jeweiligen eingetragenen Eigentümer. Allein aufgrund der bloßen Nennung ist nicht der Schluss zu ziehen, dass Markenzeichen nicht durch Rechte Dritter geschützt sind! Das Copyright für veröffentlichte, vom Autor selbst erstellte Objekte bleibt allein beim Autor der Seiten. Eine Vervielfältigung oder Verwendung solcher Grafiken, Tondokumente, Videosequenzen und Texte in anderen elektronischen oder gedruckten Publikationen ist ohne ausdrückliche Zustimmung des Autors nicht gestattet.'."\n";
		echo '    <br/><br/><br/>'."\n";
		echo '    <u>4. Datenschutz</u>'."\n";
		echo '    <br/><br/>'."\n";
		echo '    Sofern innerhalb des Internetangebotes die Möglichkeit zur Eingabe persönlicher oder geschäftlicher Daten (Emailadressen, Namen, Anschriften) besteht, so erfolgt die Preisgabe dieser Daten seitens des Nutzers auf ausdrücklich freiwilliger Basis. Die Inanspruchnahme und Bezahlung aller angebotenen Dienste ist - soweit technisch möglich und zumutbar - auch ohne Angabe solcher Daten bzw. unter Angabe anonymisierter Daten oder eines Pseudonyms gestattet. Die Nutzung der im Rahmen des Impressums oder vergleichbarer Angaben veröffentlichten Kontaktdaten wie Postanschriften, Telefon- und Faxnummern sowie Emailadressen durch Dritte zur Übersendung von nicht ausdrücklich angeforderten Informationen ist nicht gestattet. Rechtliche Schritte gegen die Versender von sogenannten Spam-Mails bei Verstössen gegen dieses Verbot sind ausdrücklich vorbehalten.'."\n";
		echo '    <br/><br/><br/>'."\n";
		echo '    <u>5. Rechtswirksamkeit dieses Haftungsausschlusses</u>'."\n";
		echo '    <br/><br/>'."\n";
		echo '    Dieser Haftungsausschluss ist als Teil des Internetangebotes zu betrachten, von dem aus auf diese Seite verwiesen wurde. Sofern Teile oder einzelne Formulierungen dieses Textes der geltenden Rechtslage nicht, nicht mehr oder nicht vollständig entsprechen sollten, bleiben die übrigen Teile des Dokumentes in ihrem Inhalt und ihrer Gültigkeit davon unberührt.'."\n";
		echo '</td>'."\n";
		echo '</tr>'."\n";
		echo '</table>'."\n";
		echo '<br/><br/><br/>'."\n";
		break;
	case "privacy";
		echo '<p><strong><big>Datenschutzerklärung</big></strong></p>';
		echo '<p><strong>Allgemeiner Hinweis und Pflichtinformationen</strong></p>';
		echo '<p><strong>Benennung der verantwortlichen Stelle</strong></p>';
		echo '<p>Die verantwortliche Stelle für die Datenverarbeitung auf dieser Website ist:</p>';
		echo '<p><span id="s3-t-firma">Name der Firma</span><br><span id="s3-t-ansprechpartner">Henning Scholland</span><br><span id="s3-t-strasse">Am Grunstedter Rain37</span><br><span id="s3-t-plz">99428</span> <span id="s3-t-ort">Weimar</span></p><p></p>';
		echo '<p>Die verantwortliche Stelle entscheidet allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten (z.B. Namen, Kontaktdaten o. Ä.).</p>';

		echo '<p><strong>Widerruf Ihrer Einwilligung zur Datenverarbeitung</strong></p>';
		echo '<p>Nur mit Ihrer ausdrücklichen Einwilligung sind einige Vorgänge der Datenverarbeitung möglich. Ein Widerruf Ihrer bereits erteilten Einwilligung ist jederzeit möglich. Für den Widerruf genügt eine formlose Mitteilung per E-Mail. Die Rechtmäßigkeit der bis zum Widerruf erfolgten Datenverarbeitung bleibt vom Widerruf unberührt.</p>';

		echo '<p><strong>Recht auf Beschwerde bei der zuständigen Aufsichtsbehörde</strong></p>';
		echo '<p>Als Betroffener steht Ihnen im Falle eines datenschutzrechtlichen Verstoßes ein Beschwerderecht bei der zuständigen Aufsichtsbehörde zu. Zuständige Aufsichtsbehörde bezüglich datenschutzrechtlicher Fragen ist der Landesdatenschutzbeauftragte des Freistaats Thüringen. Der folgende Link stellt eine Liste der Datenschutzbeauftragten sowie deren Kontaktdaten bereit: <a href="https://www.bfdi.bund.de/DE/Infothek/Anschriften_Links/anschriften_links-node.html" target="_blank">https://www.bfdi.bund.de/DE/Infothek/Anschriften_Links/anschriften_links-node.html</a>.</p>';

		echo '<p><strong>Recht auf Datenübertragbarkeit</strong></p>';
		echo '<p>Ihnen steht das Recht zu, Daten, die wir auf Grundlage Ihrer Einwilligung oder in Erfüllung eines Vertrags automatisiert verarbeiten, an sich oder an Dritte aushändigen zu lassen. Die Bereitstellung erfolgt in einem maschinenlesbaren Format. Sofern Sie die direkte Übertragung der Daten an einen anderen Verantwortlichen verlangen, erfolgt dies nur, soweit es technisch machbar ist.</p>';

		echo '<p><strong>Recht auf Auskunft, Berichtigung, Sperrung, Löschung</strong></p>';
		echo '<p>Sie haben jederzeit im Rahmen der geltenden gesetzlichen Bestimmungen das Recht auf unentgeltliche Auskunft über Ihre gespeicherten personenbezogenen Daten, Herkunft der Daten, deren Empfänger und den Zweck der Datenverarbeitung und ggf. ein Recht auf Berichtigung, Sperrung oder Löschung dieser Daten. Diesbezüglich und auch zu weiteren Fragen zum Thema personenbezogene Daten können Sie sich jederzeit über die im Impressum aufgeführten Kontaktmöglichkeiten an uns wenden.</p>';

		echo '<p><strong>SSL- bzw. TLS-Verschlüsselung</strong></p>';
		echo '<p>Aus Sicherheitsgründen und zum Schutz der Übertragung vertraulicher Inhalte, die Sie an uns als Seitenbetreiber senden, nutzt unsere Website eine SSL-bzw. TLS-Verschlüsselung. Damit sind Daten, die Sie über diese Website übermitteln, für Dritte nicht mitlesbar. Sie erkennen eine verschlüsselte Verbindung an der "https://" Adresszeile Ihres Browsers und am Schloss-Symbol in der Browserzeile.</p>';

		echo '<p><strong>Server-Log-Dateien</strong></p>';
		echo '<p>In Server-Log-Dateien erhebt und speichert der Provider der Website automatisch Informationen, die Ihr Browser automatisch an uns übermittelt. Dies sind:</p>';
		echo '<ul>';
		echo '    <li>Browsertyp und Browserversion</li>';
		echo '    <li>Verwendetes Betriebssystem</li>';
		echo '    <li>Referrer URL</li>';
		echo '    <li>Hostname des zugreifenden Rechners</li>';
		echo '    <li>Uhrzeit der Serveranfrage</li>';
		echo '    <li>IP-Adresse</li>';
		echo '</ul>';
		echo '<p>Es findet keine Zusammenführung dieser Daten mit anderen Datenquellen statt. Grundlage der Datenverarbeitung bildet Art. 6 Abs. 1 lit. b DSGVO, der die Verarbeitung von Daten zur Erfüllung eines Vertrags oder vorvertraglicher Maßnahmen gestattet.</p>';
   		break;
	}
	echo '<br/><br/><br/>'."\n";
	echo '</div>'."\n";
	echo '<table align="center" style="width:1016px;" class="infotable" cellspacing="0" cellpadding="2">'."\n";
	echo '<tr><td style="text-align:center;" class="xsmalltxt"><a href="index.php?event=impressum">Impressum\Kontakt</a> | <a href="index.php?event=privacy">Datenschutzerklärung</a> | <a href="index.php?event=disclaimer">Disclaimer</a></td></tr>'."\n";
	echo '</table>'."\n";
	echo "<br/><br/><br/>\n";
	echo '</body>'."\n";
	echo '</html>'."\n";
}
else {
// Albenübersicht (Startseite) ausgeben

//--Seitenausgabe------------------------------------------------------------------

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
	echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">'."\n";
	echo '<head>'."\n";
	echo '<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />'."\n";
	echo '<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.5)" />'."\n";
	echo '<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.5)" />'."\n";
	echo '<title>'.$websitename.'</title>'."\n";

	echo '<link rel="stylesheet" type="text/css" href="res/styles.css" />'."\n";

	echo '<style type="text/css">';
	echo 'body { background-image: url(res/bg.gif); background-repeat: repeat-x; }';
	echo '</style>'."\n";
	echo '</head>'."\n";

	echo '<body id="body">'."\n";
	echo '<div style="margin-left:auto; margin-right:auto; padding-bottom:10px; text-align:center;" />'."\n";
	echo '<table style="height:54px;" align="center" cellspacing="0" cellpadding="0" border="0">'."\n";
	echo '<tr><td>'."\n";

	echo '<table style="width:1016px;" cellspacing="0" cellpadding="0" border="0">'."\n";
	echo '<tr>'."\n";

	echo '<td style="width:20px;">'."\n";
	echo '  <img style="border:0;" src="res/hdr_left.gif" alt="" /></td>'."\n";
	echo '<td style="text-align:left; background:transparent url(res/hdr_mid.gif) repeat-x; white-space:nowrap;" class="title">'.$websitename.'</td>'."\n";
	echo '<td style="width:20px;">'."\n";
	echo '  <img style="border:0;" src="res/hdr_right.gif" alt="" /></td>'."\n";

	echo '</tr></table>'."\n";
	echo '</td></tr></table>'."\n";
	echo '<br/>'."\n";

	echo "<table align=\"center\" style=\"vertical-align:middle;\">";
	$handle = opendir('.'); // ordner mit kategorien öffnen
	$b = 0;
	while ($file = readdir ($handle)) {
		if ($file != "." && $file != ".." && $file != "res" && $file != "data" && $file != "cgi-bin" && $file != "wordpress" && $file != "baikal") { // ausschließen von ordnern
			if (is_dir($file)) {
	                    $ordner[$b] = $file; // Ordner in Array schreiben
         	       		$b++;
			}
		} //end if
	}//end while

	//Arrays alphabetisch sortieren
	sort($ordner, SORT_STRING);
	$n=0;
	$k=0;
	//while (list($key, $val) = each($ordner)) {
	foreach ($ordner as $key => $val) {
		if ($k==0) {
		echo "<tr>";
		}
		if ($b > 3) {
			echo "<td height=\"250\" width=\"320\">\n";
		}
		else {
			echo "<td height=\"500\" width=\"320\">\n";
		}

		if ($ordner[$n] != "OSM") {
			echo '<a href="'.$ordner[$n].'/index.php"><img src="res/'.strtolower($ordner[$n]).'.png" border="0" alt="'.ucwords($ordner[$n]).'" title="'.ucwords($ordner[$n]).'" /></a><br/>'."\n";
			echo '<a href="'.$ordner[$n].'/index.php">'.ucwords($ordner[$n]).'</a></td>'."\n";
		}
		else {
			echo '<a href="'.$ordner[$n].'/index.php"><img src="res/'.strtolower($ordner[$n]).'.png" border="0" alt="'.str_replace("OSM","RadReiseKarte für Garmin",ucwords($ordner[$n])).'" title="'.str_replace("OSM","RadReiseKarte für Garmin",ucwords($ordner[$n])).'" /></a><br/>'."\n";
			echo '<a href="'.$ordner[$n].'/index.php">'.str_replace("OSM","RadReiseKarte für Garmin",ucwords($ordner[$n])).'</a></td>'."\n";
		}

		$n++;
		$k++;
		if ($k > 2 && $n < $b ) {
			$k=0;
			echo "</tr>";
		}
	}
	echo "</tr></table>";

	//Text unterm Bild
	echo '<table align="center" style="width:1016px;" class="infotable" cellspacing="0" cellpadding="2">'."\n";
	echo "<tr><td style=\"text-align:center;\" class=\"xsmalltxt\"><a href=\"index.php?event=impressum\">Impressum/Kontakt</a> | <a href=\"index.php?event=privacy\">Datenschutzerklärung</a> | <a href=\"index.php?event=disclaimer\">Disclaimer</a></td></tr>"."\n";
	echo "</table>\n";
	echo "<br/><br/><br/>\n";
	echo '</body>'."\n";
	echo '</html>'."\n";
//--END Seitenausgabe------------------------------------------------------------------
//END Albenübersicht (Startseite) ausgeben
}
?>
