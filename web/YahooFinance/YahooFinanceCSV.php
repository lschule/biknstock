<?php
class YahooFinanceCSV {
	private $url = "http://ichart.finance.yahoo.com/table.csv";
	public $symbols = array(
		'ABMD','ACHC','ACUR','ADUS','AEGR','AFAM','AHPI','AIQ','AKRX','ALGN','ALXN','AMED','AMGN','AMPE','AMSG','ANCI','ANGO','APPY','ARAY','ARTC','ARWR','ATEC','ATOS','ATRC','ATRI','AVCA','BABY','BASI','BDMS','BEAT','BIOL','BOTA','BRLI','BSDM','BSPM','CASM','CBPO','CCXI','CEMI','CHDX','CPIX','CRDC','CRTX','CRVL','CUTR','CYAN','CYBX','CYNO','DHRM','DNDN','DRAD','DXCM','DYNT','ELGX','ELOS','ENDP','ENSG','ENZN','ESMC','EXAC','FONR','FORD','GENE','GHDX','GTIV','HITK','HMSY','HNSN','HOLX','HSIC','HSKA','HTWR','HWAY','HZNP','ICAD','ICUI','IDXX','IMMY','IMRS','IPCM','IRIX','IRWD','ISRG','LCAV','LFVN','LHCG','LIFE','LMAT','LPDX','LPNT','MAKO','MASI','MBLX','MDCI','MDCO','MDVN','MELA','MGCD','MGLN','MMSI','MNOV','MSLI','MSON','MTEX','MWIV','MYGN','MYL','NAII','NATR','NEO','NEOG','NSPH','NURO','NUTR','NUVA','NXTM','OFIX','PACB','PCRX','PDCO','PDEX','PHMD','PMD','PODD','PRGO','PRPH','PRTA','PSTI','PTX','QCOR','QDEL','QGEN','RDNT','RELV','RGDX','RGEN','RGLS','ROCM','ROSG','RTIX','SDIX','SGNT','SIRO','SKBI','SLTM','SNMX','SPNC','SQNM','SRDX','STAA','STML','STSI','STXS','SUPN','SURG','SVA','TEAR','TECH','THOR','TRIB','TRNX','TROV','TSON','TSPT','TZYM','ULGX','UNIS','UPI','UTHR','UTMD','VASC','VIVO','VOLC','VRML','VRML','VSCI','VSCP','WCRX','WMGI','WOOF','ZLTQ','ABIO','ACAD','ACHN','ACOR','ACRX','ACST','AEZS','AGEN','ALIM','ALKS','ALNY','ALXA','AMAG','AMRI','AMRN','ANAC','ANIK','ANTH','APPY','APRI','ARIA','ARNA','ARQL','ARRY','ASTM','ASTX','ATHX','ATRS','AUXL','AVEO','AVNR','BCRX','BDSI','BGMD','BIIB','BIOD','BLRX','BMRN','BPAX','BSTC','CADX','CBLI','CBRX','CBST','CELG','CEMP','CERS','CGEN','CHTP','CLDX','CLSN','CLVS','CNDO','CORT','CPRX','CRIS','CRME','CSII','CTIC','CYCC','CYTK','CYTR','CYTX','DARA','DCTH','DEPO','DRRX','DRTX','DSCI','DSCO','DVAX','DYAX','ECTE','ECYT','EDAP','ENMD','ETRM','EXAS','EXEL','FLML','FOLD','FURX','GALE','GALT','GENT','GERN','GEVA','GILD','GIVN','GNVC','GTXI','HALO','HPTX','ICCC','ICPT','IDIX','IDRA','IMGN','IMMU','INCY','INFI','INSM','IPCI','IPXL','ISIS','ITMN','JAZZ','KERX','KIPS','KOOL','KYTH','LGND','LMNX','LPTN','LXRX','MACK','MAXY','MDCO','MEIP','MNKD','MNTA','NBIX','NEPT','NKTR','NLNK','NPSP','NVAX','NVDQ','NVGN','NWBO','NYMX','OCLS','OGXI','OMER','ONCY','ONTY','ONXX','OPTR','OPXA','OREX','ORMP','OSIR','OSUR','OXBT','OXGN','PATH','PBMD','PCYC','PDLI','PGNX','POZN','PPHM','PRAN','PSDV','PTIE','QLTI','REGN','RIGL','RMTI','RPRX','RPTP','SCLN','SCMP','SGEN','SGMO','SGYP','SHPG','SIGA','SLXP','SNSS','SNTA','SNTS','SPPI','SRPT','SSH','STEM','TELK','THLD','THRX','TKMR','TRGT','TSRO','TSRX','TTHI','VICL','VNDA','VPHM','VRTX','VSTM','VTUS','VVUS','XNPT','XOMA','ZGNX','ZIOP','ZLCS','ABBV','ABC','ABT','ACT','ADHD','ADK','ADMP','ADXS','ADXSW','AERI','AET','AGIO','AGN','AHS','ALR','AMAG','AMBI','AMRI','AMS','ANIP','APT','ASEI','AXGN','AXN','AZN','BAX','BAXS','BCR','BDX','BIND','BIOS','BKD','BLUE','BMY','BONE','BSX','BTH','BTX','BVX','CAH','CANF','CBM','CBSTZ','CCM','CELGZ','CFN','CGIX','CHE','CI','CJJD','CMN','CMRX','CNAT','CNC','CNMD','COA','COO','COV','CPHI','CPXX','CRL','CRMD','CRY','CSU','CUR','CVD','CVM','CVS','CXM','CYCCP','CYH','CYTXW','DGX','DVA','DVCR','DXR','EBS','ELMD','ENTA','ENZ','EPZM','ERB','ESC','ESPR','ESRX','EVHC','EVOK','EW','EXAM','FATE','FCSC','FMI','FMS','FPRX','FRX','FVE','GALTU','GALTW','GCVRZ','GMED','GNMK','GRFS','GSK','GWPH','HAE','HART','HCA','HEB','HGR','HH','HLF','HLS','HMA','HNT','HRC','HRT','HSP','HTBX','HUM','IBIO','ICEL','ICLR','IG','IMUC','INFU','INO','INSY','ISR','IVC','JNJ','KBIO','KIN','KMDA','KND','KPTI','LAKE','LBMH','LCI','LDRH','LH','LLY','LUNA','LUX','MCK','MD','MDGN','MDT','MDXG','MGNX','MMM','MNK','MOH','MR','MRK','MRTX','MSA','MSTX','MZOR','NAVB','NBS','NBY','NHC','NNVC','NPD','NRCIA','NRCIB','NSPR','NSTG','NUS','NVO','NVS','NWBOW','OCR','OCRX','OGEN','OHRP','OMED','OMI','ONTX','ONVO','OPHT','OPK','OVAS','OXFD','PBH','PBYI','PETS','PETX','PFE','PIP','PLX','PMC','PRSC','PRXL','PTCT','PTLA','PTN','Q','RAD','RCPT','RDHL','RDY','RGDO','RLYP','RMD','RNA','RNN','RPRXW','RPRXZ','RTGN','RVP','SCAI','SEM','SGYPU','SGYPW','SKH','SMA','SNN','SNY','SPAN','SPEX','SRNE','SSY','STE','STJ','SYK','SYN','TARO','TEVA','TFX','TGTX','THC','TLOG','TNDM','TPI','TROVU','TROVW','TTPH','TXMD','UAM','UHS','UNH','USMD','USPH','VAR','VCYT','VRX','WAG','WCG','WLP','WMGIZ','WX','XLRN','XNCR','XON','XRAY','XTLB','ZMH','ZTS','ABAX');

	/* getCSV
	 * @params $symbol stock symbol, eg: asx.ax, bkl.ax
	 * @params $startdate optional start date. If not specified, it will return result from the earliest possible record
	 * @params $enddate optional end date. If not specified, it will return result up to the latest possible record
	 * @params $freq optional frequency. Possible values: 'd' for daily, 'm' for monthly, 'y' for yearly. Defaulted to 'd'
	 *
	 * @return csv
	 */
	public function getQuotesCSV($symbol, $startdate=NULL, $enddate=NULL, $freq='d') {
		$url = $this->url . "?s={$symbol}";
		
		if (is_string($startdate) && !empty($startdate)) {
			$startdate = new DateTime($startdate);
			$url .= "&a=" . ($startdate->format('n')-1); // start month -1
			$url .= "&b=" . $startdate->format('j');     // start day
			$url .= "&c=" . $startdate->format('y');     // start year
		}

		if (is_string($enddate) && !empty($enddate)) {
			$enddate = new DateTime($enddate);
			$url .= "&d=" . ($enddate->format('n')-1);   // end month - 1 
			$url .= "&e=" . $enddate->format('j');       // end day
			$url .= "&f=" . $enddate->format('y');       // end year
		}

		$url .= "&g=" . $freq;
		return $this->run($url);
	}

	private function run($url){
		$handle = curl_init($url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec($handle);

		$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		if ($httpCode == 404) {
			return false;
		} else {
			curl_close($handle);
			return $response;
		}
	}
}