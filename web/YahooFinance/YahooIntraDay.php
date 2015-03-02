<?php

class YahooIntraDay
{
        const TYPE_ASSOC = 1;
        const TYPE_NUM = 2;
        public $chartapi_url = "http://chartapi.finance.yahoo.com/instrument/1.0/{symbol}/chartdata;type=quote;range={range}/json/";
        
		public function getChartApi($symbol, $range)
        {
                $result = $this->exec_curl($this->getChartApiUrl($symbol, $range));
                $result = str_replace('finance_charts_json_callback', '', $result);
                $result = substr($result, 1, -1);

                if (preg_match('/errorid:/', $result)){
                	return Null;
                }
                        

                return json_decode($result);
        }

        protected function exec_curl($url)
        {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_AUTOREFERER => true,
                        CURLOPT_CONNECTTIMEOUT => 10,
                        CURLOPT_TIMEOUT => 10,
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20110619 Firefox/5.0',
                        CURLOPT_HTTPGET => true,
                        CURLOPT_URL => $url,
                        ));
                $result = curl_exec($curl);
                $error = curl_errno($curl);
                $error_message = '';

                if ($error)
                        $error_message = curl_error($curl);

                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                if ($error || $http_code != '200')
                        throw new Exception($error_message ? $error_message : $http_code, $http_code);

                return $result;
        }

 

        protected function getChartApiUrl($symbol, $range)
        {
                $available_range = array('1d', '2d');
                if (!in_array($range, $available_range))
                        throw new Exception("Invalid range");

                return str_replace(array('{symbol}', '{range}'), array($symbol, $range), $this->chartapi_url);
        }
}