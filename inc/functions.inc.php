<?php
/************************
File:		functions.inc.php
Date:		2013-06-20
Brief:		Main PHP functions file for vikeep website.
Build:		v1.0.0
************************/

// Updated default timezone...
date_default_timezone_set('America/Argentina/Buenos_Aires');

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
		$url = $this->getUrl("search.json?c=".urlencode($term)."&per_page=5&app=".$_SERVER['APP_ID']);

		$response = file_get_contents($url);
		if( $response === FALSE ) {
			return FALSE;
		}

		return json_decode($response,TRUE);
	}

	function episodes($serie,$page=1) {
		$url = $this->getUrl("containers/".$serie."/episodes.json?page=".$page."&app=".$_SERVER['APP_ID']);

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

		return json_decode($response,TRUE);
	}

	function subtitles($episode,$lang) {
		$url = $this->getUrl("videos/".$episode."/subtitles/".$lang.".srt?app=".$_SERVER['APP_ID']);

		return $url;
	}
}

class adflyAPI {
    public $apiUrl = "http://api.adf.ly/api.php";
    private $apiKey = "04b3a1a650630a1d1ee9787e4eea6aec";
    private $apiUser = "8862351";

    function getLink($url) {
        $requestUrl = $this->buildRequest($url);
		$link = file_get_contents($requestUrl);

		if( $link === FALSE ) {
			return FALSE;
		}

        return $link;
    }

    function buildRequest($url) {
        $request = $this->apiUrl;
        $request .= "?key=".$this->apiKey;
        $request .= "&uid=".$this->apiUser;
        $request .= "&advert_type=int";
        $request .= "&domain=adf.ly";
        $request .= "folder=vikeep";
        $request .= "&url=".$this->encodeURIComponent($url);

        return $request;
    }

    function encodeURIComponent($str) {
        $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
        return strtr(rawurlencode($str), $revert);
    }
}
?>
