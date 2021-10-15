<?php

function save($save,$name){
	$result = fopen($name, "a+");
	fwrite($result,"$save\n");
	fclose($result);
}

function getlistdomain($url,$saveas){
	$scrap = preg_match_all("/<td>(.*?)([a-z])<\/td>/i", $url, $page);
	$rep = str_replace('</td>', '', $page[0]);
	$rep = str_replace('<td>', '', $rep);
	$rep = preg_replace("/\/[^\/]*\/?$/i", '', $rep);
	$rep = array_filter(array_unique($rep));
	foreach ($rep as $key) {
		echo "[+] $key\n";
		save($key, $saveas);
	}
}

function getpage($from){
	$page = readline('Grab From Page (example : 1) : ');
	$page2 = readline('Grab To Page (Max Page 50) : ');
	$saveas = readline('Save As (example.txt) : ');
	if ($page2 > 51) {
		echo "\n\t Max Page Is 50!!\n";
	} else {
		while ($page <= $page2) {
			$getpages = "$from/page=$page";
			echo getlistdomain(file_get_contents($getpages), $saveas);
			$page++;
		}
	}
	echo "\n\n\t{!} Grab List Domain Success";
}

function chose(){
    echo "\033[31;1mZone-xsec\033[37;1mGrabber\n";
    
	echo "\033[35;1m1. Grab From Archive\n";
	echo "\033[33;1m2. Grab From Onhold\n";
	echo "\033[34;1m3. Grab From Special\n";
	echo "\033[36;1m4. Grab From Team\n";
	echo "\033[32;1m5. Grab From Attacker/Defacer\n";
	$chose = readline('Your Choose : ');
	switch ($chose) {
		case '1':
			$url = 'https://zone-xsec.com/archive';
			echo getpage($url);
			break;
		case '2':
			$url = 'https://zone-xsec.com/onhold';
			echo getpage($url);
			break;
		case '3':
			$url = 'https://zone-xsec.com/special';
			echo getpage($url);
			break;
		case '4':
			$name = readline('Team Name : ');
			$name = str_replace(' ', '%20', $name);
			$url = "https://zone-xsec.com/archive/team/$name";
			echo getpage($url);
			break;
		case '5':
			$name = readline('Name Attacker/Defacer : ');
			$name = str_replace(' ', '%20', $name);
			$url = "https://zone-xsec.com/archive/attacker/$name";
			echo getpage($url);
			break;
		default:
			echo "\n\tChose 1-5!!\n";
			break;
	}
}

chose();
