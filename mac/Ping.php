<?php
function pr($v) {
	echo '<pre>' . htmlentities(print_r($v, 1)) . '</pre>';
}
class Ping {

	public function macFromIp($ip) {
		$cmd = "/home/hackathon/hackathon/mac2 {$ip}";
		$respuesta = shell_exec($cmd);
		pr($cmd);
		pr($respuesta);
	}

	public function isMacOnline($mac) {

	}
}

$ip = $_SERVER['REMOTE_ADDR'];
$Ping = new Ping();
$Ping->macFromIp($ip);
//shell_exec('sudo arp-scan --interface=eth0 192.168.1.0/24');

