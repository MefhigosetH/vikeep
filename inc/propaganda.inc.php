<?php
/************************
File:		propaganda.inc.php
Date:		2015-03-05
Brief:		Propaganda class and methods for Adds and Banners.
Build:		v1.0.0
************************/

class propaganda {
    private $openTag = "<table class='table table-bordered'>\r\n<thead><tr><th><center>Propaganda</center></th></tr></thead>\r\n<tbody><tr><td><center>\r\n";
    private $closeTag = "</center></td></tr></tbody></table>";

    private $propellerAdd = "<iframe src='//go.padstm.com/?id=199127&t=iframe' style='width:728px;height:90px;border:0;overflow:hidden;'></iframe>\r\n";
    private $fidelityAdd = "<!-- BEGIN JS TAG - vikeep.herokuapp.com 728x90 < - DO NOT MODIFY -->\r\n<SCRIPT SRC='http://ib.adnxs.com/ttj?id=4361434&size=728x90&promo_sizes=300x50,320x50,468x60,216x36&promo_alignment=center' TYPE='text/javascript'>\r\n</SCRIPT>\r\n<!-- END TAG -->\r\n";


    function printCurrAdd() {
        echo $this->openTag;
        echo $this->fidelityAdd;
        echo $this->closeTag;

        return TRUE;
    }
}
