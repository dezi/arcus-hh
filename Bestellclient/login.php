<?php

include("json.php");
include("config.php");

function login()
{
	$user = $_GET[ "user" ];
	$pass = $_GET[ "pass" ];
	
	$data = "null";

	if ($user && $pass)
	{
		if (isset($GLOBALS[ "benutzer" ][ $user ]))
		{
			$userconf = $GLOBALS[ "benutzer" ][ $user ];
		
			if (isset($userconf[ "pass" ]) && ($userconf[ "pass" ] == $pass))
			{
				$data = $userconf;
				unset($data[ "pass" ]);
				
				$data[ "user" ] = $user;
				$data[ "time" ] = time();
				$data[ "sach" ] = $GLOBALS[ "sachgebiete" ];
				$data[ "jobs" ] = readJobs($user);
				
				$data = json_encdat($data);
			}
		}
	}

	echo "bestell.loginCallback($data);";
}

function sortJobs($a, $b)
{
    if ($a[ "name" ] == $b[ "name" ]) return 0;
    return ($a[ "name" ] > $b[ "name" ]) ? -1 : 1;
}

function readJobs($user)
{
	$jobdir = "data/$user/jobs";
	$xmldir = "data/$user/xmls";
	
	if (! file_exists($jobdir)) mkdir($jobdir, 0777, true);
	if (! file_exists($xmldir)) mkdir($xmldir, 0777, true);
	
	$jobs = array();
	
	$dfd = opendir($jobdir);
	
	if ($dfd)
	{
		while (($entry = readdir($dfd)) !== false)
		{
			if ($entry == ".") continue;
			if ($entry == "..") continue;
			
			if (substr($entry, -5) != ".json") continue;
			
			$jobfile = "$jobdir/$entry";
			
			$job = json_decdat(file_get_contents($jobfile));
			$jobid = substr($entry, 0, -5);
			
			$jobs[] = $job;
		}
		closedir($dfd);
	}
			
	usort($jobs, "sortJobs");

	return $jobs;
}

login();

?>