<?php
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;


require 'YahooFinance/YahooFinanceCSV.php'; 

class StockManager {
	private $ESUrl  = '188.166.13.229:9200';
	private $client;

	public function __construct() {
		$connectParams = array();
		$connectParams['hosts'] = array (
			$this->ESUrl
			);

			$this->client = new Elasticsearch\Client($connectParams);
	}

	private function deleteIndexes() {
		$deleteParams['index'] = 'stock_data_day';
		try{
			$this->client->indices()->delete($deleteParams);
		}catch(Exception $e){
		//LOGME
		}
	}
	
	
	private function createHistoryIndex(){
		$this->deleteIndexes();
		
		$createParams['index']  = 'stock_data_day';    //index
		$this->client->indices()->create($createParams);
	
		// Set the index and type
		$params['index'] = 'stock_data_day';
		$params['type']  = 'stock_data_day_type';
	
		// Defining the Index
		//symbol,`date`,`open`,`high`,`low`,`close`,`volume`,`adj_close`,`open_high_ratio`,`close_open_ratio`
		$definition = array(
		    '_source' => array(
		        'enabled' => true
		    ),
		    'properties' => array(
		        'symbol' => array(
		            'type' => 'string',
		            'analyzer' => 'standard'
		        ),
		        'date' => array(
		            'type' => 'date'
		        ),
		        'open' => array(
		            'type' => 'double'
		        ),
		        'high' => array(
		            'type' => 'double'
		        ),
		        'low' => array(
		            'type' => 'double'
		        ),
		        'close' => array(
		            'type' => 'double'
		        ),
		        'volume' => array(
		            'type' => 'long'
		        ),
		         'adj_close' => array(
		            'type' => 'double'
		        ),
		         'open_high_ratio' => array(
		            'type' => 'double'
		        ),
		         'close_open_ratio' => array(
		            'type' => 'double'
		        ),
		        'volume_avg' => array(
		            'type' => 'double'
		        ),
		         'volume_ratio' => array(
		            'type' => 'double'
		        ),
		        'date_before' => array(
		            'type' => 'date'
		        ),
		         'volume_ratio_before' => array(
		            'type' => 'double'
		        )
		    )
		);
		$params['body']['stock_data_day_type'] = $definition;
	
		// Update the index mapping
		$this->client->indices()->putMapping($params);

	}
	
	private function createIntraDayIndex(){
		
		$deleteParams['index'] = 'stock_data_intra_day';
		try{
			$this->client->indices()->delete($deleteParams);
		}catch(Exception $e){
		//LOGME
		}
		
		$createParams['index']  = 'stock_data_intra_day';    //index
		$this->client->indices()->create($createParams);
	
		// Set the index and type
		$params['index'] = 'stock_data_intra_day';
		$params['type']  = 'stock_data_intra_day_type';
	
		// Defining the Index
		//for the intraday structure : date | time | open | high | low | close | volume | splits | earnings | dividends
		$definition = array(
		    '_source' => array(
		        'enabled' => true
		    ),
		    'properties' => array(
		        'symbol' => array(
		            'type' => 'string',
		            'analyzer' => 'standard'
		        ),
		        'date' => array(
		            'type' => 'date'
		        ),
		        'time' => array(
		            'type' => 'date',
		            'format' => 'basic_time_no_millis'
		        ),
		        'open' => array(
		            'type' => 'double'
		        ),
		        'high' => array(
		            'type' => 'double'
		        ),
		        'low' => array(
		            'type' => 'double'
		        ),
		        'close' => array(
		            'type' => 'double'
		        ),
		        'volume' => array(
		            'type' => 'long'
		        )
		    )
		);
		$params['body']['stock_data_intra_day_type'] = $definition;
	
		// Update the index mapping
		$this->client->indices()->putMapping($params);

	}
	
	
	private function normalize_val($val){
		if(isset($val)){
			return $val;
		}else{
			return 0;
		}
	}
	
	private function initiate_db(){
		$mysqli = new mysqli("localhost", "root", "", "stockdb");
		if ($mysqli->connect_errno) {
		    echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		return $mysqli;
	}

	
	public function initiateES(){
		set_time_limit(0);
		$time_start = microtime(true);
		$this->createHistoryIndex();
		
		$yf = new YahooFinanceCSV;
		
		$symbols = $yf->symbols;
		foreach ($symbols as $symbol) {
			$historicaldata = $yf->getQuotesCSV($symbol);
			$historicaldata_row = explode("\n", $historicaldata);
			$last_close = 0;
			$avg_vol = 0;
			$avg_vol_old = 0;
			$volume_ratio_before = 0;
			$date_before= '1921-01-01' ;
			$i=0;
			$params = array();
			//later we compare "yesterday" with "today", so it's important to have the list in the right order
			$historicaldata_reversed = array_reverse($historicaldata_row);
			foreach ($historicaldata_reversed as $line){
				$i++;
				
				
				//store the value of the day before in variables:
				if(isset($date)){
					$date_before = $date;
				}
				if(isset($volume_ratio)){
					$volume_ratio_before = $volume_ratio;
				}
				
				$line_array = explode(",",$line);		
				if(count($line_array)<2 || $line_array[0] == "Date"){
					continue;
				}
				if(isset($line_array[0])){
					$date = $line_array[0];
				}else{
					$date = '1921-01-01';
				}
				
				$open = $this->normalize_val($line_array[1]);
				$high = $this->normalize_val($line_array[2]);
				$low = $this->normalize_val($line_array[3]);
				$close = $this->normalize_val($line_array[4]);
				$volume = $this->normalize_val($line_array[5]);
				$adj_close = $this->normalize_val($line_array[6]);
				
				if($avg_vol > 0){
					//after the first data is arrived
					$avg_vol_old = $avg_vol;
				}elseif($volume > 0){
					//first time
					$avg_vol_old = $volume;
				}else{
					//avoid possible division by 0
					$avg_vol_old = 1;
				}
				
				
				
				
				$avg_vol = (($avg_vol * ($i-1)) + $volume) / $i;
				$volume_ratio = ($volume/$avg_vol_old)*100;
								
				if($open > 0){
					$openHighRatio = ($high-$open)/$open;
				}else{
					$openHighRatio = 0;
				}
	
				if($last_close > 0){
					$closeOpenRatio = ($open-$last_close)/$last_close;
					if ($closeOpenRatio > 0.5){
					}else{
					}
				}else{
					$closeOpenRatio = 0.0;
				}
				$last_close = $close;
				
				//Insert the data in Index
				$params['body'][] = array(
			        'index' => array(
			            '_index' => "stock_data_day",
			            '_type' => "stock_data_day_type"
			        )
			    );
//symbol,`date`,`open`,`high`,`low`,`close`,`volume`,`adj_close`,`open_high_ratio`,`close_open_ratio`, volume_ratio
			    $params['body'][] = array(
			        'symbol' => $symbol,
			        'date' => $date,
			        'open' => $open,
			        'high' => $high,
			        'low' => $low,
			        'close' => $close,
			        'volume' => $volume,
			        'adj_close' => $adj_close,
			        'open_high_ratio' => $openHighRatio,
			        'close_open_ratio' => $closeOpenRatio,
			        'volume_avg' => $avg_vol,
			        'volume_ratio' => $volume_ratio,
			        'date_before' => $date_before,
			        'volume_ratio_before' => $volume_ratio_before
			    );
			}
			if (!empty($params)){
				$responses = $this->client->bulk($params);
			}
		}
		$time_end = microtime(true);
		$time = $time_end - $time_start;
		return "Import completed in".gmdate("H:i:s", $time);
	}
	
	public function getDataDay ($closeOpen,$openHigh,$year = Null, $vol_ratio = NULL){
		
			$rangeQuery =  array();
			$rangeQuery[] = array(
				"range" => array(
					"open_high_ratio" => array(
						"gte" => $openHigh
					)
				)
			);
			$rangeQuery[] = array(
				"range" => array(
					"close_open_ratio" => array(
						"gte" => $closeOpen,
						"lte" => 2,
					)
				)
			);
			
			if(isset($year)){
				$year_before = $year-1;
				$year_before .= "-12-31";
				$rangeQuery[] = array(
					"range" => array(
						"date" => array(
							"gte" => $year_before,
						)
					)
				);
			}
			
			if(isset($vol_ratio)){
				$rangeQuery[] = array(
				"range" => array(
					"volume_ratio" => array(
						"gte" => $vol_ratio,
					)
				)
			);
			}

			

			$params['index'] = 'stock_data_day';
			$params['type']  = 'stock_data_day_type';
			$params['body']['query']['filtered']['filter']['bool']["must"] = $rangeQuery;
			$params['body']['fields'] = array("symbol","date","close_open_ratio","open_high_ratio","volume","volume_ratio","date_before","volume_ratio_before");
			$params['body']['size'] = 10000;
			$match = $this->client->search($params);
			return $match["hits"]["hits"];
			
	}
	
	public function getIntraDay($symbol,$date){
		$termQuery =  array();
		$termQuery[] = array(
			"query_string" => array(
				"default_field" => "date",
				"query" => $date
			)
		);
		$termQuery[] = array(
			"query_string" => array(
				"default_field" => "symbol",
				"query" => $symbol
			)
		);
		
		$sortArray = array();
		$sortArray[] = array(
			"time" => array("order" => "asc")
			);
		
		
		$params['index'] = 'stock_data_intra_day';
		$params['type']  = 'stock_data_intra_day_type';
		$params['body']['query']['bool']["must"] = $termQuery;
		$params['body']['sort']= $sortArray;
		$params['body']['fields'] = array("time","close","volume");
		$params['body']['size'] = 10000;
		$match = $this->client->search($params);
		return $match["hits"]["hits"];
	}
	
	public function importIntraDay(){
		set_time_limit(0); 
		$time_start = microtime(true);
		$this->createIntraDayIndex();
		//There is too much data in the CSVs to import everything, so we limitate the number of data we import but just taking the days that match an intersting day. 
		
		$interesting_matches = $this->getDataDay(0.1,0.0,2008);
		//build an array to use later for the CSV search -> array(symbol=>array(matching dates))
		$matchesForCSV = array();
		foreach($interesting_matches as $interesting_match){
			$matchesForCSV[$interesting_match["fields"]["symbol"][0]][] = $interesting_match["fields"]["date"][0];
		}
		foreach($matchesForCSV as $symbol => $dates){
			$fileName = '/vagrant/web/intra_day_data/table_'.strtolower($symbol).'.csv';
			if (file_exists($fileName)){
				$params = array();
				//open the matching CSV file
				$lexer = new Lexer(new LexerConfig());
				$interpreter = new Interpreter();
				$interpreter->addObserver(function(array $row) use (&$params,$dates,$symbol)  {
				    /*
					    array (size=10)
						  0 => string '20100104' (length=8)
						  1 => string '930' (length=3)
						  2 => string '5.36' (length=4)
						  3 => string '5.36' (length=4)
						  4 => string '5.36' (length=4)
						  5 => string '5.36' (length=4)
						  6 => string '740' (length=3)
						  7 => string '1' (length=1)
						  8 => string '0' (length=1)
						  9 => string '0' (length=1)
				    */
				    $date = date("Y-m-d", strtotime($row[0]));
				    if (in_array($date,$dates)){
					    //Insert the data in Index
						$params['body'][] = array(
					        'index' => array(
					            '_index' => "stock_data_intra_day",
					            '_type' => "stock_data_intra_day_type"
					        )
					    );
		//symbol,`date`,`open`,`high`,`low`,`close`,`volume`,`adj_close`,`open_high_ratio`,`close_open_ratio`
					    $params['body'][] = array(
					        'symbol' => $symbol,
					        'date' => $row[0],
					        'time' => $row[1],
					        'open' => $row[2],
					        'high' => $row[3],
					        'low' => $row[4],
					        'close' => $row[5],
					        'volume' => $row[6]
					    );
				    }
				});
				$lexer->parse($fileName, $interpreter);
				//insert in ES
				if (!empty($params)){
					$responses = $this->client->bulk($params);
				}
				
			}else{
				continue; 
			}
		}
		$time_end = microtime(true);
		$time = $time_end - $time_start;
		return "Import completed in".gmdate("H:i:s", $time);
	}
}