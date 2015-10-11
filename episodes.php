<?php
/************************
File:		episodes.php
Date:		2015-02-01
Brief:		Episodes routine file.

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
include("inc/functions.inc.php");
include("inc/viki.inc.php");
include("inc/adfly.inc.php");
include("inc/propaganda.inc.php");
?>
<!DOCTYPE html>
<html>

<? include('inc/header.inc.php'); ?>

<body>

<?php include('inc/navbar.inc.php'); ?>

<div class="container">

<?php
if( isset($_GET['episode']) && !empty($_GET['episode']) ) {
	$viki = new vikiAPI();
    $adfly = new adflyApi();
?>

<!-- Start add banner -->
<?php
$propaganda = new propaganda();
$propaganda->printRandAdd();
?>
<!-- End add banner -->

<!-- EpisodeResults -->
<div class="page-header">
<h1>Select your download preferences</h1>

</div>
<?php
	echo "<h3>1. Download subtitles. Choose your lang:</h3>";
	echo "<p>Right-click -> Save as...</p>";
	$strEsUrl = $adfly->getLink($viki->subtitles($_GET['episode'],"es"));
	$strPtUrl = $adfly->getLink($viki->subtitles($_GET['episode'],"pt"));
	$strEnUrl = $adfly->getLink($viki->subtitles($_GET['episode'],"en"));
	$strFrUrl = $adfly->getLink($viki->subtitles($_GET['episode'],"fr"));
	echo "<p>";
	echo "<a href='".$strEsUrl."' title='Download Spanish subtitles' class='btn btn-large btn-primary'><i class='icon-list-alt icon-white'></i> Spanish</a>";
	echo " <a href='".$strPtUrl."' title='Download Português subtitles' class='btn btn-large btn-primary'><i class='icon-list-alt icon-white'></i> Português</a>";
	echo " <a href='".$strFrUrl."' title='Download French subtitles' class='btn btn-large btn-primary'><i class='icon-list-alt icon-white'></i> French</a>";
	echo " <a href='".$strEnUrl."' title='Download English subtitles' class='btn btn-large btn-primary'><i class='icon-list-alt icon-white'></i> English</a>";
	echo "</p>";

	$vikiStreams = $viki->streams($_GET['episode']);

	if( $vikiStreams !== FALSE ) {

		echo "<h3>2. Download video. Choose your quality:</h3>";
		echo "<p>Click, wait 5 sec, and then click again on the right up corner yellow button.</p>";
		echo "<p>";

		foreach( $vikiStreams as $quality => $data ) {
            if( $quality == "external" ) {
                echo "Sory. No streams available to download :-(";
            }
            else {
                $adflyUrl = $adfly->getLink($_SERVER['SERVER_NAME']."/stream.php?id=".$_GET['episode']."&quality=".$quality);
			    echo "<a href='".$adflyUrl."' title='Download video in ".$quality."' class='btn btn-large btn-primary'><i class='icon-download-alt icon-white'></i> ".$quality."</a> ";
            }
		}

		echo "</p>";
	}
}
else {
    echo "<p>Sory. No streams available to download :-(</p>";
}
?>

</div>

<? include('inc/footer.inc.php'); ?>

</body>
</html>
