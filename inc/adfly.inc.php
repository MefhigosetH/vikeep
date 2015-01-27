<?php
/************************
File:		adfly.inc.php
Date:		2015-01-27
Brief:		Adf.ly class and methods.
Build:		v1.0.0
************************/

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
