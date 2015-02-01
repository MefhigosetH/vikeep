<?php
/************************
File:		search.php
Date:		2015-01-26
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
include('inc/functions.inc.php');
include('inc/viki.inc.php');
?>
<!DOCTYPE html>
<html>

<? include('inc/header.inc.php'); ?>

<body>

<?php include('inc/navbar.inc.php'); ?>

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
<h1>Search results <small>for <?php echo htmlentities($q); ?></small></h1>
</div>

<?php
if( !empty($q) ) {
	$viki = new vikiAPI();

	if( !isset($_GET['page']) ) {
		$_GET['page'] = 1;
	}

	$_GET['page'] = (int) $_GET['page'];
	$vikiSearch = $viki->search($q,$_GET['page']);
	$count = count($vikiSearch['response']);

	if( $count ){
		for( $i=0;$i<$count;$i++) {
			$id = $vikiSearch['response'][$i]['id'];
			$title = $vikiSearch['response'][$i]['titles']['en'];
			$poster = $vikiSearch['response'][$i]['images']['poster']['url'];
			$episodes = $vikiSearch['response'][$i]['episodes']['count'];

			if( !empty($episodes) ) {
				echo "<div class='hero-unit text-center'>\r\n";
                echo "<h1>".$title."</h1><span class='label label-info'>".$episodes." episodes</span>\r\n";
                if( $vikiSearch['response'][$i]['flags']['on_air'] == 1 ) { echo "<span class='label label-success'>on-air</span>\r\n"; }
				echo "<p><img src='".$poster."' alt='".$title."' class='img-polaroid' /></p>\r\n";
                if( $vikiSearch['response'][$i]['flags']['hosted'] == 1 ) {
                    echo "<p><a class='btn btn-large btn-primary text-left' href='series.php?serie=".$id."' title='View episodes for ".$title."'><i class='icon-eye-open icon-white'></i> Show episodes</a></p>\r\n";
                }
                else {
                    echo "<div class='alert alert-info'><h4>External</h4> This serie is not hosted at viki.com</div>\r\n";
                }
				echo "</div>\r\n";
			}
		}

        echo "<!-- Paging div -->\r\n";
        echo "<div class='row'>\r\n";
        echo "<ul class='pager'>\r\n";

        if( $_GET['page']>1 ) {
            echo "<li class='previous'>\r\n";
            echo "<a href='?q=".$q."&page=".($_GET['page']-1)."'>&larr; Previous</a>\r\n";
            echo "</li>\r\n";
        }
        else {
            echo "<li class='previous disabled'>\r\n";
            echo "<a href='#'>&larr; Previous</a>\r\n";
            echo "</li>\r\n";
        }

        if($vikiSearch['more']) {
            echo "<li class='next'>\r\n";
            echo "<a href='?q=".$q."&page=".($_GET['page']+1)."'>Next &rarr;</a>\r\n";
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
		echo "<p>No results.</p>";
	}
}
else {
	echo "<p>No results.</p>";
}
?>

</div>

<? include('inc/footer.inc.php'); ?>

</body>
</html>
