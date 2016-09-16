<?php

include("json.php");
include("config.php");

function update()
{
	$ok = false;
	
	$user = $_GET[ "user" ];
	$mode = $_GET[ "mode" ];
	
	$jobname = $_GET[ "jobname" ];
	$jobdate = $_GET[ "jobdate" ];
	$jobsend = $_GET[ "jobsend" ];
	
	if ($jobname)
	{
		$userdir = "data/$user/jobs";
		
		if (file_exists($userdir))
		{
			$jobfile = "$userdir/$jobname.json";
			
			if ($mode == "d")
			{
				unlink($jobfile);
				$ok = true;
			}
			
			if ($mode == "u")
			{
				$data = array();
				
				if (file_exists($jobfile))
				{
					$data = json_decdat(file_get_contents($jobfile));
				}
				
				if ($jobname) $data[ "name" ] = $jobname;
				if ($jobdate) $data[ "date" ] = $jobdate;
				if ($jobsend) $data[ "send" ] = $jobsend;
				
				file_put_contents($jobfile, json_encdat($data) . "\n");
				
				$ok = true;
			}
		}
	}
	
	echo "bestell.updateCallback(" . ($ok ? "true" : "false") . ");";
}

update();

?>