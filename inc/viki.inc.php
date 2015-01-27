<?php
/************************
File:		viki.inc.php
Date:		2015-01-27
Brief:		Viki.com API main class and methods.
Build:		v1.0.0
************************/

class vikiAPI {
	public $apiUrl = "http://api.viki.io";
	public $apiPath = "/v4/";

	function getUrl( $string="" ) {
		$sign = "";
		$url = "";
		$url .= $this->apiPath.$string;
		$url .= "&t=".time();

		$sign = hash_hmac('sha1',$url,$_SERVER['APP_SECRET']);

		$url = $this->apiUrl.$url."&sig=".$sign;
		return $url;
	}

	function search($term,$page=1) {
        // This HTTP request was sniffed from viki.com site...
        //GET http://api.viki.io/v4/search.json?c=dre&licensed=0&per_page=5&with_paywall=1&il=en&cl=en&app=100000a&t=1421888623
		//$url = $this->getUrl("search.json?c=".urlencode($term)."&per_page=5&app=".$_SERVER['APP_ID']);
        $url = $this->apiUrl.$this->apiPath."search.json?term=".urlencode($term)."&type=series&page=".$page."&app=".$_SERVER['WEB_ID']."&t=".time();

		$response = file_get_contents($url);
		if( $response === FALSE ) {
			return FALSE;
		}

		return json_decode($response,TRUE);
	}

	function episodes($serie,$page=1) {
		$url = $this->apiUrl.$this->apiPath."containers/".$serie."/episodes.json?page=".$page."&app=".$_SERVER['WEB_ID']."&t=".time();

		$response = file_get_contents($url);
		if( $response === FALSE ) {
			return FALSE;
		}

		return json_decode($response,TRUE);
	}

	function streams($episode) {
		$url = $this->getUrl("videos/".$episode."/streams.json?app=".$_SERVER['APP_ID']);
		$response = file_get_contents($url);

		if( $response === FALSE ) {
			return FALSE;
		}

        $json_response = json_decode($response,TRUE);

        if( isset($json_response['error']) ) {
            return FALSE;
        }

		return $json_response;
	}

	function subtitles($episode,$lang) {
		$url = $this->getUrl("videos/".$episode."/subtitles/".$lang.".srt?app=".$_SERVER['APP_ID']);

		return $url;
	}
}

?>
