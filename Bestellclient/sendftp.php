<?php

include("json.php");
include("config.php");

function getQuery($name)
{
	return isset($_GET[ $name ]) ? $_GET[ $name ] : null;
}

function sendftp()
{
	$result = false;
	
	$user = getQuery("user");
	$jobname = getQuery("jobname");
	
	if ($jobname)
	{
		$userdir = "data/$user";
		
		$jobdir = "$userdir/jobs";
		$xmldir = "$userdir/xmls";
		
		if (file_exists($jobdir))
		{
			$jobfile = "$jobdir/$jobname.json";
			$xmlfile = "$xmldir/$jobname.xml";
			
			if (file_exists($jobfile))
			{
				$data = json_decdat(file_get_contents($jobfile));
				
				$result = generateXML($xmlfile, $data, $user);
			}
		}
	}		

	echo "bestell.sendftpCallback(" . ($result ? "true" : "false") . ", \"$jobname\");";
}

function alphaOnlyUpper($str)
{
	$str = str_replace("ä", "ae", $str);
	$str = str_replace("ö", "ae", $str);
	$str = str_replace("ü", "ue", $str);
	$str = str_replace("ß", "ss", $str);
	
	$str = mb_strtoupper($str, "UTF-8");
	
	$new = "";
	
	for ($inx = 0; $inx < strlen($str); $inx++)
	{
		if ((ord("A") <= ord($str[ $inx ])) && (ord($str[ $inx ]) <= ord("Z")))
		{
			$new .= $str[ $inx ];
		}
	}
	
	return $new;
}

function artikelKey($item)
{
	//
	// 29.05.1962
	// 0123456789
	//
	
	$key  = substr($item[ "source" ], 0, 3);
	$key .= "-";
	$key .= substr($item[ "date" ], 6, 4);
	$key .= substr($item[ "date" ], 3, 2);
	$key .= substr($item[ "date" ], 0, 2);
	$key .= "-";
	$key .= str_pad($item[ "page" ], 5, "0", STR_PAD_LEFT);
	$key .= "-";
	$key .= str_pad(alphaOnlyUpper($item[ "title" ]), 43, "+", STR_PAD_RIGHT);

	//
	// STZ-20160906-00009-AUSBRUCHAUS+++++++++++++
	// 1234567890123456789012345678901234567890123
	//

	return substr($key, 0, 43);
}

function artikelRaw($item)
{
	$key  = substr($item[ "date" ], 6, 4);
	$key .= substr($item[ "date" ], 3, 2);
	$key .= substr($item[ "date" ], 0, 2);
	$key .= $item[ "guid" ];
	
	return $key;
}

function getDayOfWeek($datum)
{
	$parts = explode(".", $datum);
	
	if (count($parts) == 3)
	{
		$day   = intVal($parts[ 0 ], 10);
		$month = intVal($parts[ 1 ], 10);
		$year  = intVal($parts[ 2 ], 10);
	
		$wday = date("w", mktime(0, 0, 0, $month - 1, $day, $year));
		
		if ($wday == 0) return "Sonntag";
		if ($wday == 1) return "Montag";
		if ($wday == 2) return "Dienstag";
		if ($wday == 3) return "Mittwoch";
		if ($wday == 4) return "Donnerstag";
		if ($wday == 5) return "Freitag";
		if ($wday == 6) return "Samstag";
	}
	
	return "Pupsenkacke";
}

function generateXML($xmlfile, $job, $user)
{
	$conf = $GLOBALS[ "benutzer" ][ $user ];
	
	$xml = array();
	
	$xml[] = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
	$xml[] = "<?xml-stylesheet type=\"text/xsl\" href=\"acbest02.xsl\" ?>";
	
	$xml[] = "<bestell>";
	
	if (isset($job[ "items" ]))
	{
		$items = $job[ "items" ];
	
		for ($inx = 0; $inx < count($items); $inx++)
		{
			$item = $items[ $inx ];
		
			$akey =	artikelKey($item);
			$rkey =	artikelRaw($item);
					
			$xml[] = "\t<artikel artikelkey=\"$akey\" rawkey=\"$rkey\">";
			$xml[] = "\t\t<head>";
			
			//
			// auftrag
			//
			
			$title = $item[ "title" ];
			$userid = $conf[ "userid" ];
			$custom = $conf[ "custom" ];
			$enotify = $conf[ "enotify" ];
			
			$xml[] = "\t\t\t<auftrag customs=\"$custom\" elements=\"newtext\">";
			
			$xml[] = "\t\t\t\t<custom name=\"$custom\" elektra=\"nein\" formkont=\"ja\" ocr=\"ja\" img=\"nein\" />";
			$xml[] = "\t\t\t\t<needs>newtext</needs>";
			$xml[] = "\t\t\t\t<actions></actions>";
			$xml[] = "\t\t\t\t<titelanriss>$title</titelanriss>";
			$xml[] = "\t\t\t\t<lektorat></lektorat>";
			$xml[] = "\t\t\t\t<enotify>$enotify</enotify>";
			$xml[] = "\t\t\t\t<userid>$userid</userid>";
			$xml[] = "\t\t\t\t<textanriss></textanriss>";
			$xml[] = "\t\t\t\t<externvalues></externvalues>";

			$xml[] = "\t\t\t</auftrag>";
			
			//
			// formal
			//
			
			$xml[] = "\t\t\t<formal>";
			
			$quname = trim(substr($item[ "source" ], 6));
			$qukurz = trim(substr($item[ "source" ], 0, 3));
			
			$xml[] = "\t\t\t\t<quelle>";
			$xml[] = "\t\t\t\t\t<quname>$quname</quname>";
			$xml[] = "\t\t\t\t\t<qukurz>$qukurz</qukurz>";
			$xml[] = "\t\t\t\t</quelle>";			
			
			$datum = $item[ "date" ];
			$wtag = getDayOfWeek($datum);
			
			$xml[] = "\t\t\t\t<ausgabe>";
			$xml[] = "\t\t\t\t\t<datum>$datum</datum>";
			$xml[] = "\t\t\t\t\t<wtag>$wtag</wtag>";
			$xml[] = "\t\t\t\t\t<nummer></nummer>";
			$xml[] = "\t\t\t\t</ausgabe>";

			$seite = $item[ "page" ];
			
			$xml[] = "\t\t\t\t<seiten>";
			$xml[] = "\t\t\t\t\t<startseite>$seite</startseite>";
			$xml[] = "\t\t\t\t\t<endseite>$seite</endseite>";
			$xml[] = "\t\t\t\t\t<einzeln>";
			$xml[] = "\t\t\t\t\t\t<seite>$seite</seite>";
			$xml[] = "\t\t\t\t\t</einzeln>";
			$xml[] = "\t\t\t\t</seiten>";
			
			$sach = isset($item[ "sach" ]) ? explode(", ", $item[ "sach" ]) : array();

			$xml[] = "\t\t\t\t<sachgebiete>";
			foreach ($sach as $sg) $xml[] = "\t\t\t\t\t<sachgebiet>$sg</sachgebiet>";
			$xml[] = "\t\t\t\t</sachgebiete>";

			$xml[] = "\t\t\t\t<autoren></autoren>";
			$xml[] = "\t\t\t\t<kategorie></kategorie>";
			$xml[] = "\t\t\t\t<textsorte></textsorte>";
			$xml[] = "\t\t\t\t<laender></laender>";

			$xml[] = "\t\t\t</formal>";

			//
			// inhalt
			//
			
			$xml[] = "\t\t\t<inhalt></inhalt>";

			$xml[] = "\t\t</head>";
			$xml[] = "\t\t<body></body>";
			$xml[] = "\t</artikel>";
		}
	}
	
	$xml[] = "</bestell>\n";

	file_put_contents($xmlfile, implode("\r\n", $xml) . "\r\n");
	
	return false;
}

sendftp();

?>