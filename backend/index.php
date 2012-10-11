<?php
require 'vendor/autoload.php';
 
$app = new \Slim\Slim();

$cadenadb = 'mysql:dbname=bigbrother;host=localhost';

		try {

			$app->pdodbh = new PDO(
					$cadenadb,
					 'bigbrother',
					 'bigbrother');
			$app->pdodbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {

			echo "Error Connection: " . $e->getMessage();
			file_put_contents("resources/logs/Connection-log.txt", DATE . PHP_EOL . $e->getMessage() . PHP_EOL . PHP_EOL, FILE_APPEND);
		}
		//print_r($app->pdodbh);
		
$app->get('/personas', function () use ($app) { 
	 
	
	$personasST=$app->pdodbh->query("select * from personas");
	$personasRS=$personasST->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($personasRS);
	
	 
	//echo json_encode(array('personas'=>$personaRS));
	
	});

$app->get('/status', function () use ($app) { 
	
	$ipvisitante=$_SERVER['REMOTE_ADDR'];
	$macvisitante=damemac($ipvisitante);
	//echo 'tu mac es'.$macvisitante;
	$macST=$app->pdodbh->query("select * from personas where mac_address='$macvisitante'");
	$macRS=$macST->fetchAll(PDO::FETCH_ASSOC);
	if(sizeof($macRS)==0) {
		$status=false;
		$insertST=$app->pdodbh->prepare("insert into personas (mac_address,online) values (:mac,1)");
	//	$insertST->execute(array(':mac'=>1));
	} else {
		if ($macRS[0]['nickname']=='') {
		$status=false;
		
		} else {
		$status=true;
		}
	}
	echo json_encode(array( 'status'=>$status));
	
	});
	
$app->get('/cron', function () use ($app) { 
	$personasST=$app->pdodbh->query("select * from personas");
	$personasRS=$personasST->fetchAll(PDO::FETCH_ASSOC);
	foreach ($personasRS as $persona) {
		$mac = $persona["mac_address"];
		$online = isonline($mac);
		if ($online != $persona["online"]) {
			try {
				$app->pdodbh->exec("update personas set online = $online where mac_address = '$mac'");
				$app->halt(200,  json_encode(array( 'result'=>true)));
			} catch (PDOException $e) {
				$app->halt(500,  json_encode(array( 'result'=>false)));
			} 
		}
	}
	
});

$app->post('/persona', function () use ($app) { 
	
	$ipvisitante=$_SERVER['REMOTE_ADDR'];
	$macvisitante=damemac($ipvisitante);
	$nickname=$app->request()->post('nickname');
 		
		
		$insertST=$app->pdodbh->prepare("replace into personas (mac_address,nickname,  ip, online) values (:mac,:nickname, :ip,1)");
		try {
			$insertST->execute(array(':mac'=>$macvisitante,
								
								':nickname'=>$nickname,':ip'=>$ipvisitante));
				echo json_encode(array( 'result'=>true));
				
				
 
		} catch (PDOException $e) {
			
			$app->halt(500,  json_encode(array( 'result'=>false)));
		}
		});



$app->run();

function damemac($ip) {
	return md5(time());	
}

function isonline($mac) {
return rand(0,1);	

}

 


?>
