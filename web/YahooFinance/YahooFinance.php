<?php

class YahooFinance {
	private $yqlUrl  = "http://query.yahooapis.com/v1/public/yql";
	private $options = array("env" => "http://datatables.org/alltables.env",				// need this env to query yahoo finance
							);
	private $format;

	public function __construct($format='json') {
		if (isset($format)) {
			switch ($format) {
				case 'json':
					$this->options['format'] = 'json';
					break;
			}
		}
	}

	public function getQuotes($symbols) {
		if (is_string($symbols)) {
			$symbols = array($symbols);
		}

		$options = $this->options;
		$options['q'] = "select * from yahoo.finance.quotes where symbol in ('" . implode("','", $symbols) . "')";
		
		return $this->execQuery($options);
	}

	public function getQuotesList($symbols) {
		if (is_string($symbols)) {
			$symbols = array($symbols);
		}

		$options = $this->options;
		$options['q'] = "select * from yahoo.finance.quoteslist where symbol in ('" . implode("','", $symbols) . "')";
		
		return $this->execQuery($options);
	}

	private function execQuery($options) {
		$yql_query_url = $this->getUrl($options);
		$session = curl_init($yql_query_url);  
		curl_setopt($session, CURLOPT_RETURNTRANSFER,true);      
		return curl_exec($session);    		
	}

	private function getUrl($options) {
		$url = $this->yqlUrl;
		$i=0;
		foreach ($options as $k => $qstring) {
			if ($i==0) {
				$url .= '?';
			} else {
				$url .= '&';
			}
			$url .= "$k=" . urlencode($qstring);
			$i++;
		}
		return $url;
	}

	private function dateToDBString($date) {
		assert('is_object($date) && get_class($date) == "DateTime"');

		return $date->format('Y-m-d');
	}

	public function getQuotesAvgPrice(){
		$return_array = array();
		
		
		
		
		$string1 = "'ABMD','ACHC','ACUR','ADUS','AEGR','AFAM','AHPI','AIQ','AKRX','ALGN','ALXN','AMED','AMGN','AMPE','AMSG','ANCI','ANGO','APPY','ARAY','ARTC','ARWR','ATEC','ATOS','ATRC','ATRI','AVCA','BABY','BASI','BDMS','BEAT','BIOL','BOTA','BRLI','BSDM','BSPM','CASM','CBPO','CCXI','CEMI','CHDX','CPIX','CRDC','CRTX','CRVL','CUTR','CYAN','CYBX','CYNO','DHRM','DNDN','DRAD','DXCM','DYNT','ELGX','ELOS','ENDP','ENSG','ENZN','ESMC','EXAC','FONR','FORD','GENE','GHDX','GTIV','HITK','HMSY','HNSN','HOLX','HSIC','HSKA','HTWR','HWAY','HZNP','ICAD','ICUI','IDXX','IMMY','IMRS','IPCM','IRIX','IRWD','ISRG','LCAV','LFVN','LHCG','LIFE','LMAT','LPDX','LPNT','MAKO','MASI'";
		
		
		

		$string2 = "'MBLX','MDCI','MDCO','MDVN','MELA','MGCD','MGLN','MMSI','MNOV','MSLI','MSON','MTEX','MWIV','MYGN','MYL','NAII','NATR','NEO','NEOG','NSPH','NURO','NUTR','NUVA','NXTM','OFIX','PACB','PCRX','PDCO','PDEX','PHMD','PMD','PODD','PRGO','PRPH','PRTA','PSTI','PTX','QCOR','QDEL','QGEN','RDNT','RELV','RGDX','RGEN','RGLS','ROCM','ROSG','RTIX','SDIX','SGNT','SIRO','SKBI','SLTM','SNMX','SPNC','SQNM','SRDX','STAA','STML','STSI','STXS','SUPN','SURG','SVA','TEAR','TECH','THOR','TRIB','TRNX','TROV','TSON','TSPT','TZYM','ULGX','UNIS','UPI','UTHR','UTMD','VASC','VIVO','VOLC','VRML','VRML','VSCI','VSCP','WCRX','WMGI','WOOF','ZLTQ','ABIO','ACAD','ACHN','ACOR','ACRX','ACST','AEZS','AGEN','ALIM','ALKS','ALNY','ALXA','AMAG','AMRI','AMRN','ANAC','ANIK','ANTH','APPY','APRI','ARIA','ARNA','ARQL','ARRY','ASTM','ASTX','ATHX','ATRS','AUXL','AVEO','AVNR','BCRX','BDSI','BGMD','BIIB','BIOD','BLRX','BMRN','BPAX','BSTC','CADX','CBLI','CBRX','CBST','CELG','CEMP','CERS','CGEN','CHTP','CLDX','CLSN','CLVS','CNDO','CORT','CPRX','CRIS','CRME','CSII','CTIC','CYCC','CYTK','CYTR','CYTX','DARA','DCTH','DEPO','DRRX','DRTX','DSCI','DSCO','DVAX','DYAX','ECTE','ECYT','EDAP','ENMD'";
		

		$string3 = "'ETRM','EXAS','EXEL','FLML','FOLD','FURX','GALE','GALT','GENT','GERN','GEVA','GILD','GIVN','GNVC','GTXI','HALO','HPTX','ICCC','ICPT','IDIX','IDRA','IMGN','IMMU','INCY','INFI','INSM','IPCI','IPXL','ISIS','ITMN','JAZZ','KERX','KIPS','KOOL','KYTH','LGND','LMNX','LPTN','LXRX','MACK','MAXY','MDCO','MEIP','MNKD','MNTA','NBIX','NEPT','NKTR','NLNK','NPSP','NVAX','NVDQ','NVGN','NWBO','NYMX','OCLS','OGXI','OMER','ONCY','ONTY','ONXX','OPTR','OPXA','OREX','ORMP','OSIR','OSUR','OXBT','OXGN','PATH','PBMD','PCYC','PDLI','PGNX','POZN','PPHM','PRAN','PSDV','PTIE','QLTI','REGN','RIGL','RMTI','RPRX','RPTP','SCLN','SCMP','SGEN','SGMO','SGYP','SHPG','SIGA','SLXP','SNSS','SNTA','SNTS','SPPI','SRPT','SSH','STEM','TELK','THLD','THRX','TKMR','TRGT','TSRO','TSRX','TTHI','VICL','VNDA','VPHM','VRTX','VSTM','VTUS','VVUS','XNPT','XOMA','ZGNX','ZIOP','ZLCS','ABBV','ABC','ABT','ACT','ADHD','ADK','ADMP','ADXS','ADXSW','AERI','AET','AGIO','AGN','AHS','ALR','AMAG','AMBI','AMRI','AMS','ANIP','APT','ASEI','AXGN','AXN','AZN','BAX','BAXS','BCR','BDX','BIND','BIOS','BKD','BLUE','BMY','BONE','BSX','BTH','BTX','BVX','CAH','CANF','CBM','CBSTZ','CCM','CELGZ','CFN','CGIX','CHE','CI','CJJD','CMN','CMRX','CNAT','CNC','CNMD','COA','COO'";


		$string4 = "'COV','CPHI','CPXX','CRL','CRMD','CRY','CSU','CUR','CVD','CVM','CVS','CXM','CYCCP','CYH','CYTXW','DGX','DVA','DVCR','DXR','EBS','ELMD','ENTA','ENZ','EPZM','ERB','ESC','ESPR','ESRX','EVHC','EVOK','EW','EXAM','FATE','FCSC','FMI','FMS','FPRX','FRX','FVE','GALTU','GALTW','GCVRZ','GMED','GNMK','GRFS','GSK','GWPH','HAE','HART','HCA','HEB','HGR','HH','HLF','HLS','HMA','HNT','HRC','HRT','HSP','HTBX','HUM','IBIO','ICEL','ICLR','IG','IMUC','INFU','INO','INSY','ISR','IVC','JNJ','KBIO','KIN','KMDA','KND','KPTI','LAKE','LBMH','LCI','LDRH','LH','LLY','LUNA','LUX','MCK','MD','MDGN','MDT','MDXG','MGNX','MMM','MNK','MOH','MR','MRK','MRTX','MSA','MSTX','MZOR','NAVB','NBS','NBY','NHC','NNVC','NPD','NRCIA','NRCIB','NSPR','NSTG','NUS','NVO','NVS','NWBOW','OCR','OCRX','OGEN','OHRP','OMED','OMI','ONTX','ONVO','OPHT','OPK','OVAS','OXFD','PBH','PBYI','PETS','PETX','PFE','PIP','PLX','PMC','PRSC','PRXL','PTCT','PTLA','PTN','Q','RAD','RCPT','RDHL','RDY','RGDO','RLYP','RMD','RNA','RNN','RPRXW','RPRXZ','RTGN','RVP','SCAI','SEM','SGYPU','SGYPW','SKH','SMA','SNN','SNY','SPAN','SPEX','SRNE','SSY','STE','STJ','SYK','SYN','TARO','TEVA','TFX','TGTX','THC','TLOG','TNDM','TPI','TROVU','TROVW','TTPH','TXMD','UAM','UHS','UNH','USMD','USPH','VAR','VCYT','VRX','WAG','WCG','WLP','WMGIZ','WX','XLRN','XNCR','XON','XRAY','XTLB','ZMH','ZTS','ABAX'";
	
		$return_array = array_merge($return_array, $this->getYQLResult($string1));
		$return_array = array_merge($return_array, $this->getYQLResult($string2));
		$return_array = array_merge($return_array, $this->getYQLResult($string3));
		$return_array = array_merge($return_array, $this->getYQLResult($string4));
		return $return_array;
		
	}
	
	protected function getYQLResult($string){
		$options = $this->options;
		$options['q'] = "select * from yahoo.finance.quotes where symbol in (". $string .")";
		$result =  $this->execQuery($options);
		$result_arr = json_decode($result);
		
		return $result_arr->query->results->quote;
	} 

		

	}

