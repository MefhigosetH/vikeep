<?php
/************************
File:		series.php
Date:		2015-02-01
Brief:		Series routine file for viki.

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
?>
<!DOCTYPE html>
<html>

<? include('inc/header.inc.php'); ?>

<body>

<?php include('inc/navbar.inc.php'); ?>

<div class="container">
<?php
if( isset($_GET['serie']) && !empty($_GET['serie']) ) {
	$viki = new vikiAPI();

	if( !isset($_GET['page']) ) {
		$_GET['page'] = 1;
	}
	$_GET['page'] = (int) $_GET['page'];
?>
<!-- SerieResults -->
<div class="page-header">
<h1>Select your episode</h1>

<!-- start Add banner -->
<fieldset><legend>Propaganda</legend>
<script type="text/javascript">
  ( function() {
    if (window.CHITIKA === undefined) { window.CHITIKA = { 'units' : [] }; };
    var unit = {"calltype":"async[2]","publisher":"MefhigosetH","width":468,"height":60,"sid":"Chitika Default"};
    var placement_id = window.CHITIKA.units.length;
    window.CHITIKA.units.push(unit);
    document.write('<div id="chitikaAdBlock-' + placement_id + '"></div>');
}());
</script>
<script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>
</fieldset>
<!-- End Add banner -->

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
			echo "<p><a href='episodes.php?episode=".$id."' class='btn btn-primary'><i class='icon-download icon-white'></i> Download</a></p>\r\n";
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
		echo "<p>Sin episodios.</p>";
}
?>

</div>

<? include('inc/footer.inc.php'); ?>

</body>
</html>
