<?php
/************************
File:		search.php
Date:		2014-01-26
Brief:		Search engine routine file.

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

<?php
$q = "";

if( isset($_POST['q']) ) {
	$q = $_POST['q'];
}
else {
	$q = $_GET['q'];
}
?>

<div class="container">
<!-- SearchResults -->
<div class="page-header">
<h1>Search results <small>for <?php echo $q; ?></small></h1>
</div>

<?php
if( !empty($q) ) {
	$viki = new vikiAPI();

	if( !isset($_GET['page']) ) {
		$_GET['page'] = 1;
	}

	$_GET['page'] = (int) $_GET['page'];
	$vikiSearch = $viki->search($q,$_GET['page']);
	$count = count($vikiSearch);

	if( $count ){
		for( $i=0;$i<$count;$i++) {
			$id = $vikiSearch[$i]['id'];
            $type = $vikiSearch[$i]['t'];
			$title = $vikiSearch[$i]['tt'];
			$poster = $vikiSearch[$i]['i'];

			if( $type == "series" ) {
				echo "<div class='hero-unit text-center'>\r\n";
				echo "<h1>".$title."</h1>\r\n";
				echo "<span class='label label-success'>".$type."</span>\r\n";
                echo "<span class='label label-info'>".$vikiSearch[$i]['e']." episodes</span>\r\n";
				echo "<p><img src='".$poster."' alt='".$title."' class='img-polaroid' /></p>\r\n";
				echo "<p><a class='btn btn-large btn-primary text-left' href='index.php?serie=".$id."' title='View episodes for ".$title."'><i class='icon-eye-open icon-white'></i> Show episodes</a></p>\r\n";
				echo "</div>\r\n";
			}
		}

		echo "</ul></div>\r\n";
	}
	else {
		echo "<p>No results.</p>";
	}
}
else {
	echo "<p>No results.</p>";
}
?>

</div>

<? include('footer.inc.php'); ?>

</body>
</html>
