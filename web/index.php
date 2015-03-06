<?php

require 'flight/Flight.php';
require 'StockManager.php'; 
require 'YahooFinance/YahooFinance.php'; 
require 'YahooFinance/YahooIntraDay.php'; 
require '../vendor/autoload.php';


Flight::route('/', function(){
    Flight::render('header');
	getDataDay(0.3, 0.3,2010);
	Flight::render('footer');
});

Flight::route('/getStocks/@year/@closeOpen/@openHigh/@ratio', function($year,$closeOpen, $openHigh,$vol_ratio){
	Flight::render('header');
	getDataDay($closeOpen, $openHigh,$year,$vol_ratio);
	Flight::render('footer');
});
Flight::route('/getStocks/@year/@closeOpen/@openHigh', function($year,$closeOpen, $openHigh){
	Flight::render('header');
	getDataDay($closeOpen, $openHigh,$year);
	Flight::render('footer');
});
Flight::route('/getStocks/@closeOpen/@openHigh', function($closeOpen, $openHigh){
	Flight::render('header');
	getDataDay($closeOpen, $openHigh);
	Flight::render('footer');
});
Flight::route('/intraDay/@symbol/@date', function($symbol,$date){
	getIntraDay($symbol,$date);
});

Flight::route('/importIntraDay/', function(){
	Flight::render('header');
	importIntraDay();
	Flight::render('footer');
});


Flight::route('/initiateES/', function(){
	Flight::render('header');
	initiateES();
	Flight::render('footer');
});


Flight::start();


function getDataDay ($closeOpen,$openHigh,$year = Null, $vol_ratio = NULL){
	$stockManager = new StockManager();
	$results = $stockManager->getDataDay($closeOpen,$openHigh,$year, $vol_ratio);
	$params = array("cor" => $closeOpen,
					"ohr" => $openHigh,
					"year" => $year,
					"vol_ratio" => $vol_ratio,
					"count" => count($results),
					"data" => $results
	);
	Flight::render('getStock', $params);

}

function getIntraDay ($symbol,$date){
	$stockManager = new StockManager();
	$results = $stockManager->getIntraDay($symbol,$date);
	if(empty($results)){
		Flight::render('no_intra');
	}else{
		$times = array();
		$closes = array();
		$volumes = array();
		$timesCloses = array();
		
		foreach($results as $line){
			$times[] = $line["fields"]["time"][0];
			$closes[] = $line["fields"]["close"][0];
			$volumes[] = $line["fields"]["volume"][0];
			$timesCloses[] = $line["fields"]["time"][0].",".$line["fields"]["close"][0];
		}
		
		$params = array("times" => $times,
						"closes" => $closes,
						"volumes" => $volumes,
						"timesCloses" => $timesCloses,
		
		);
		Flight::render('intra_day', $params);
	}
}

function importIntraDay (){
	$stockManager = new StockManager();
	$results = $stockManager->importIntraDay();
	echo $results;
}


function initiateES(){
	$stockManager = new StockManager();
	$result = $stockManager->initiateES();
	echo $result;
}

?>