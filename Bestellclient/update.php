<?php

include("json.php");
include("config.php");

function sortItems($a, $b)
{
    if ($a[ "guid" ] == $b[ "guid" ]) return 0;
    return ($a[ "guid" ] > $b[ "guid" ]) ? -1 : 1;
}

function getQuery($name)
{
	return isset($_GET[ $name ]) ? $_GET[ $name ] : null;
}

function update()
{
	$result = false;
	
	$user = getQuery("user");
	$mode = getQuery("mode");
	
	$jobname = getQuery("jobname");
	$jobdate = getQuery("jobdate");
	$jobsend = getQuery("jobsend");
	
	$guid   = getQuery("guid"  );
	$source = getQuery("source");
	$date   = getQuery("date"  );
	$page   = getQuery("page"  );
	$sach   = getQuery("sach"  );
	$title  = getQuery("title" );
	$notes  = getQuery("notes" );
	$ok     = getQuery("ok"    );
		
	if ($jobname)
	{
		$userdir = "data/$user/jobs";
		
		if (file_exists($userdir))
		{
			$jobfile = "$userdir/$jobname.json";
			
			if (($mode == "d") && ($guid === null))
			{
				unlink($jobfile);
				$result = true;
			}
			else
			{
				$data = array();
			
				if (file_exists($jobfile))
				{
					$data = json_decdat(file_get_contents($jobfile));
				}
			
				if ($jobname) $data[ "name" ] = $jobname;
				if ($jobdate) $data[ "date" ] = $jobdate;
				if ($jobsend) $data[ "send" ] = $jobsend;
			
				if ($guid)
				{
					if (! isset($data[ "items" ])) $data[ "items" ] = array();
					$items = &$data[ "items" ];
				
					for ($iteminx = 0; $iteminx < count($items); $iteminx++)
					{
						if ($items[ $iteminx ][ "guid" ] == $guid) break;
					}
				
					if ($mode == "d")
					{
						if ($iteminx < count($items)) array_splice($items, $iteminx, 1);
					}
					else
					{
						if ($iteminx == count($items)) $items[] = array();
				
						if ($guid   !== null) $items[ $iteminx ][ "guid"   ] = $guid;
						if ($source !== null) $items[ $iteminx ][ "source" ] = $source;
						if ($date   !== null) $items[ $iteminx ][ "date"   ] = $date;
						if ($page   !== null) $items[ $iteminx ][ "page"   ] = $page;
						if ($sach   !== null) $items[ $iteminx ][ "sach"   ] = $sach;
						if ($title  !== null) $items[ $iteminx ][ "title"  ] = $title;
						if ($notes  !== null) $items[ $iteminx ][ "notes"  ] = $notes;
						if ($ok     !== null) $items[ $iteminx ][ "ok"     ] = ($ok == "true");
				
						usort($data[ "items" ], "sortItems");
					}
				}
			
				file_put_contents($jobfile, json_encdat($data) . "\n");
			
				$result = true;
			}
		}
	}
	
	echo "bestell.updateCallback(" . ($result ? "true" : "false") . ", \"$jobname\");";
}

update();

?>