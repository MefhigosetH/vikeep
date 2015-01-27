<?php
/************************
File:		stream.php
Date:		2015-01-22
Brief:		Viki streams download resource.

Legal notice:
    Vikeep. Keep viki.com videos, yours.
    Copyright (C) 2013  Victor Villarreal <mefhigoseth@gmail.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.

************************/
include('inc/functions.inc.php');
include('inc/viki.inc.php');

if( isset($_GET['id']) && isset($_GET['quality']) ) {

	$viki = new vikiAPI();
	$vikiStreams = $viki->streams($_GET['id']);
	$count = count($vikiStreams);

	if( $count ) {
        if( isset($vikiStreams[$_GET['quality']]) ) {
			$url = $vikiStreams[$_GET['quality']]['http']['url'];

            $ch = @curl_init();
            @curl_setopt($ch, CURLOPT_URL, $url);
            @curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);
            @curl_setopt($ch, CURLOPT_NOBODY, TRUE);
            //curl_setopt($ch, CURLOPT_HEADER, FALSE);
            @curl_exec($ch);
            $info = @curl_getinfo($ch);
            @curl_close($ch);

            @header("Cache-Control: no-cache, must-revalidate");
            @header("Pragma: no-cache");
            @header("Content-Disposition: attachment; filename= ".$_GET['id']."-".$_GET['quality'].".mp4");
            @header("Content-Type: ".$info['content_type']);
            @header("Content-Transfer-Encoding: binary");
            @header("Content-Length: ".$info['download_content_length']);


            $fp = fopen($url,"rb");
            if(ob_get_length() > 0) { ob_end_clean(); }
            @fpassthru($fp);
            fclose($fp);
            exit;
        }
	}
    else {
        echo "Error: No available streams for episode ID ".$_GET['id'];
    }
}
else {
    echo "Error: Episode ID or Quality not set.";
}
?>
