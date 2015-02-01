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
include('inc/functions.inc.php');
?>
<!DOCTYPE html>
<html>

<? include('inc/header.inc.php'); ?>

<body>

<?php include('inc/navbar.inc.php'); ?>

<div class="container">

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

<? include('inc/footer.inc.php'); ?>

</body>
</html>
