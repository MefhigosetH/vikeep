<?php
/************************
File:		index.php
Date:		2013-06-20
Brief:		Main index file for vikeep website.

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
include('functions.inc.php');
?>
<!DOCTYPE html>
<html>

<? include('header.inc.php'); ?>

<body>

<?php include('navbar.inc.php'); ?>

<div class="container">
<?php
if( isset($_GET['episode']) && !empty($_GET['episode']) ) {
	$viki = new vikiAPI();
    $adfly = new adflyApi();
?>
<!-- EpisodeResults -->
<div class="page-header">
<h1>Select your download preferences</h1>
</div>
<?php
	$vikiStreams = $viki->streams($_GET['episode']);
	$count = count($vikiStreams);

	if( $count ) {
		echo "<h3>1. Download subtitles. Choose your lang:</h3>";
		echo "<p>Right-click -> Save as...</p>";
		$strEsUrl = $viki->subtitles($_GET['episode'],"es");
		$strPtUrl = $viki->subtitles($_GET['episode'],"pt");
		$strEnUrl = $viki->subtitles($_GET['episode'],"en");
		$strFrUrl = $viki->subtitles($_GET['episode'],"fr");
		echo "<p>";
		echo "<a href='".$strEsUrl."' title='Download Spanish subtitles' class='btn btn-large btn-primary'><i class='icon-list-alt icon-white'></i> Spanish</a>";
		echo " <a href='".$strPtUrl."' title='Download Português subtitles' class='btn btn-large btn-primary'><i class='icon-list-alt icon-white'></i> Português</a>";
		echo " <a href='".$strFrUrl."' title='Download French subtitles' class='btn btn-large btn-primary'><i class='icon-list-alt icon-white'></i> French</a>";
		echo " <a href='".$strEnUrl."' title='Download English subtitles' class='btn btn-large btn-primary'><i class='icon-list-alt icon-white'></i> English</a>";
		echo "</p>";

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
elseif( isset($_GET['serie']) && !empty($_GET['serie']) ) {
	$viki = new vikiAPI();

	if( !isset($_GET['page']) ) {
		$_GET['page'] = 1;
	}
	$_GET['page'] = (int) $_GET['page'];
?>
<!-- SerieResults -->
<div class="page-header">
<h1>Select your episode</h1>
</div>
<?php
	$vikiEpisodes = $viki->episodes($_GET['serie'],$_GET['page']);
	$count = count($vikiEpisodes['response']);

	if( $count ) {
		echo "<div class='row'>\r\n";
		echo "<ul class='thumbnails'>\r\n";
		for($i=0;$i<$count;$i++) {
			$id = $vikiEpisodes['response'][$i]['id'];
			$number = $vikiEpisodes['response'][$i]['number'];
			$poster = $vikiEpisodes['response'][$i]['images']['poster']['url'];

			echo "<li class='span6'>\r\n";
			echo "<div class='thumbnail'>\r\n";
			echo "<img src='".$poster."' alt='Episode ".$number."' />\r\n";
			echo "<div class='caption'>\r\n";
			echo "<h3>Episode ".$number."</h3>\r\n";
			echo "<p><a href='index.php?episode=".$id."' class='btn btn-primary'><i class='icon-download icon-white'></i> Download</a></p>\r\n";
			echo "</div></div></li>\r\n\r\n";
		}
		echo "</ul></div>\r\n";

		echo "<!-- Paging div -->\r\n";
		echo "<div class='row'>\r\n";
		echo "<ul class='pager'>\r\n";

		if( $_GET['page']>1 ) {
			echo "<li class='previous'>\r\n";
			echo "<a href='?serie=".$_GET['serie']."&page=".($_GET['page']-1)."'>&larr; Previous</a>\r\n";
			echo "</li>\r\n";
		}
		else {
			echo "<li class='previous disabled'>\r\n";
			echo "<a href='#'>&larr; Previous</a>\r\n";
			echo "</li>\r\n";
		}

		if($vikiEpisodes['more']) {
			echo "<li class='next'>\r\n";
			echo "<a href='?serie=".$_GET['serie']."&page=".($_GET['page']+1)."'>Next &rarr;</a>\r\n";
			echo "</li>\r\n";
		}
		else {
			echo "<li class='next disabled'>\r\n";
			echo "<a href='#'>Next &rarr;</a>\r\n";
			echo "</li>\r\n";
		}

		echo "</ul></div>\r\n";
	}
	else {
		echo "<p>Sin episodios.</p>";
	}
}
else {
?>

<!-- HeroUnit -->
<div class="hero-unit text-center">
	<h1>Keep viki.com videos, yours.</h1>
	<p>Search what you want to download from viki.com</p>
	<form action="search.php" method="post">
	<input class="input-block-level" id="appendedInputButton" type="text" name="q" autocomplete="off" value="" />
	<button class="btn btn-large btn-primary" type="submit"><i class="icon-search icon-white"></i> Search!</button>
	</form>
</div>

<blockquote>
Vikeep allows you to search your favorite series and download to your computer the chapters and subtitles you want. All for free ;-)<small>About this site</small>
</blockquote>

<div class="row">
	<div class="span4">
	<div class="page-header">
		<h1>Facebook <small>fanpage</small></h1>
	</div>
    <!-- Facebook like box -->
    <div class="fb-like-box" data-href="https://www.facebook.com/vikeep.page" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
	</div>

	<div class="span4">
	<div class="page-header">
		<h1>Colaborate <small>with us</small></h1>
	</div>
	<p>If you enjoy this site, please consider donating.</p>
	<br />
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" class="text-center">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="NFL5S9YQQW5F2">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
	</form>
	</div>

	<div class="span4">
	<div class="page-header">
		<h1>Twitter <small>hashtag</small></h1>
	</div>
    <!-- Twitter timeline -->
    <a class="twitter-timeline"  href="https://twitter.com/hashtag/vikeep" data-widget-id="559595313603026946">Tweets sobre #vikeep</a>
	</div>

</div>
<?php
}
?>

</div>

<? include('footer.inc.php'); ?>

</body>
</html>
