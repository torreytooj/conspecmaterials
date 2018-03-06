<?php
	$column1 = ot_get_option('fm_column1');
	$column2 = ot_get_option('fm_column2');
	$column3 = ot_get_option('fm_column3');
	$column4 = ot_get_option('fm_column4');
	$sm_label = ot_get_option('sm_label'); 
    $pinterest = ot_get_option('pinterest');
    $dropbox = ot_get_option('dropbox');
    $google_plus = ot_get_option('google_plus');
    $jolicloud = ot_get_option('jolicloud');
    $yahoo = ot_get_option('yahoo');
    $blogger = ot_get_option('blogger');
    $picasa = ot_get_option('picasa');
    $amazon = ot_get_option('amazon');
    $tumblr = ot_get_option('tumblr');
    $wordpress = ot_get_option('wordpress');
    $instapaper = ot_get_option('instapaper');
    $evernote = ot_get_option('evernote');
    $xing = ot_get_option('xing');
    $zootool = ot_get_option('zootool');
    $dribbble = ot_get_option('dribbble');
    $deviantart = ot_get_option('deviantart');
    $read_it_later = ot_get_option('read_it_later');
    $linked_in = ot_get_option('linked_in');
    $forrst = ot_get_option('forrst');
    $pinboard = ot_get_option('pinboard');
    $behance = ot_get_option('behance');
    $github = ot_get_option('github');
    $youtube = ot_get_option('youtube');
    $skitch = ot_get_option('skitch');
    $foursquare = ot_get_option('foursquare');
    $quora = ot_get_option('quora');
    $badoo = ot_get_option('badoo');
    $spotify = ot_get_option('spotify');
    $stumbleupon = ot_get_option('stumbleupon');
    $readability = ot_get_option('readability');
    $facebook = ot_get_option('facebook');
    $twitter = ot_get_option('twitter');
    $instagram = ot_get_option('instagram');
    $posterous_spaces = ot_get_option('posterous_spaces');
    $vimeo = ot_get_option('vimeo');
    $flickr = ot_get_option('flickr');
    $last_fm = ot_get_option('last_fm');
    $rss = ot_get_option('rss');
    $skype = ot_get_option('skype');
    $e_mail = ot_get_option('e_mail');
    $vine = ot_get_option('vine');
    $myspace = ot_get_option('myspace');
    $goodreads = ot_get_option('goodreads');
    $apple = ot_get_option('apple');
    $windows = ot_get_option('windows');
    $yelp = ot_get_option('yelp');
    $playstation = ot_get_option('playstation');
    $xbox = ot_get_option('xbox');
    $android = ot_get_option('android');
    $ios = ot_get_option('ios');
?>

<?php 
	
	$social_media = $pinterest||$dropbox||$google_plus||$jolicloud||$yahoo||$blogger||$picasa||$amazon||$tumblr||$wordpress||$instapaper||$evernote||$xing||$zootool||$dribbble||$deviantart||$read_it_later||$linked_in||$forrst||$pinboard||$behance||$github||$youtube||$skitch||$foursquare||$quora||$badoo||$spotify||$stumbleupon||$readability||$facebook||$twitter||$instagram||$posterous_spaces||$vimeo||$flickr||$last_fm||$rss||$skype||$e_mail||$vine||$myspace||$goodreads||$apple||$windows||$yelp||$playstation||$xbox||$android||$ios;
	
	$column_1 = ($social_media)||$column1;
	
	
	if($column_1&&$column2&&$column3&&$column4){
		$column_type = "col-md-3";
	} elseif($column_1&&$column2&&$column3){
		$column_type = "col-md-4";
	} elseif($column_1&&$column2){
		$column_type = "col-md-6";
	}else{
		$column_type = "col-md-12";
	}
	
	
?>

	<?php if($column_1||$column2||$column3||$column4){?>
	<div class="footer-meta <?php if ( is_active_sidebar(8)||is_active_sidebar(3) ){?>footer-meta-border<?php }?>">
		<div class="container">
			<div class="row">
				<?php if($column_1){?>
				<div class="<?php echo $column_type;?>">
					<?php if($social_media){?>
					<div class="social-media">
					
						<?php if($sm_label){?><span class="sm_label"><?php echo $sm_label;?></span><?php }?>
						
						<?php if($pinterest){?><a class="social social-icon pinterest" href="<?php echo $pinterest;?>"></a><?php }?>
						<?php if($dropbox){?><a class="social social-icon dropbox" href="<?php echo $dropbox;?>"></a><?php }?>
						<?php if($google_plus){?><a class="social social-icon google_plus" href="<?php echo $google_plus;?>"></a><?php }?>
						<?php if($jolicloud){?><a class="social social-icon jolicloud" href="<?php echo $jolicloud;?>"></a><?php }?>
						<?php if($yahoo){?><a class="social social-icon yahoo" href="<?php echo $yahoo;?>"></a><?php }?>
						<?php if($blogger){?><a class="social social-icon blogger" href="<?php echo $blogger;?>"></a><?php }?>
						<?php if($picasa){?><a class="social social-icon picasa" href="<?php echo $picasa;?>"></a><?php }?>
						<?php if($amazon){?><a class="social social-icon amazon" href="<?php echo $amazon;?>"></a><?php }?>
						<?php if($tumblr){?><a class="social social-icon tumblr" href="<?php echo $tumblr;?>"></a><?php }?>
						<?php if($wordpress){?><a class="social social-icon wordpress" href="<?php echo $wordpress;?>"></a><?php }?>
						<?php if($instapaper){?><a class="social social-icon instapaper" href="<?php echo $instapaper;?>"></a><?php }?>
						<?php if($evernote){?><a class="social social-icon evernote" href="<?php echo $evernote;?>"></a><?php }?>
						<?php if($xing){?><a class="social social-icon xing" href="<?php echo $xing;?>"></a><?php }?>
						<?php if($zootool){?><a class="social social-icon zootool" href="<?php echo $zootool;?>"></a><?php }?>
						<?php if($dribbble){?><a class="social social-icon dribbble" href="<?php echo $dribbble;?>"></a><?php }?>
						<?php if($deviantart){?><a class="social social-icon deviantart" href="<?php echo $deviantart;?>"></a><?php }?>
						<?php if($read_it_later){?><a class="social social-icon read_it_later" href="<?php echo $read_it_later;?>"></a><?php }?>
						<?php if($linked_in){?><a class="social social-icon linked_in" href="<?php echo $linked_in;?>"></a><?php }?>
						<?php if($forrst){?><a class="social social-icon forrst" href="<?php echo $forrst;?>"></a><?php }?>
						<?php if($pinboard){?><a class="social social-icon pinboard" href="<?php echo $pinboard;?>"></a><?php }?>
						<?php if($behance){?><a class="social social-icon behance" href="<?php echo $behance;?>"></a><?php }?>
						<?php if($github){?><a class="social social-icon github" href="<?php echo $github;?>"></a><?php }?>
						<?php if($youtube){?><a class="social social-icon youtube" href="<?php echo $youtube;?>"></a><?php }?>
						<?php if($skitch){?><a class="social social-icon skitch" href="<?php echo $skitch;?>"></a><?php }?>
						<?php if($foursquare){?><a class="social social-icon foursquare" href="<?php echo $foursquare;?>"></a><?php }?>
						<?php if($quora){?><a class="social social-icon quora" href="<?php echo $quora;?>"></a><?php }?>
						<?php if($badoo){?><a class="social social-icon badoo" href="<?php echo $badoo;?>"></a><?php }?>
						<?php if($spotify){?><a class="social social-icon spotify" href="<?php echo $spotify;?>"></a><?php }?>
						<?php if($stumbleupon){?><a class="social social-icon stumbleupon" href="<?php echo $stumbleupon;?>"></a><?php }?>
						<?php if($readability){?><a class="social social-icon readability" href="<?php echo $readability;?>"></a><?php }?>
						<?php if($facebook){?><a class="social social-icon facebook" href="<?php echo $facebook;?>"></a><?php }?>
						<?php if($twitter){?><a class="social social-icon twitter" href="<?php echo $twitter;?>"></a><?php }?>
						<?php if($instagram){?><a class="social social-icon instagram" href="<?php echo $instagram;?>"></a><?php }?>
						<?php if($posterous_spaces){?><a class="social social-icon posterous_spaces" href="<?php echo $posterous_spaces;?>"></a><?php }?>
						<?php if($vimeo){?><a class="social social-icon vimeo" href="<?php echo $vimeo;?>"></a><?php }?>
						<?php if($flickr){?><a class="social social-icon flickr" href="<?php echo $flickr;?>"></a><?php }?>
						<?php if($last_fm){?><a class="social social-icon last_fm" href="<?php echo $last_fm;?>"></a><?php }?>
						<?php if($rss){?><a class="social social-icon rss" href="<?php echo $st_javascript;?>"></a><?php }?>
						<?php if($skype){?><a class="social social-icon skype" href="<?php echo $skype;?>"></a><?php }?>
						<?php if($e_mail){?><a class="social social-icon e-mail" href="<?php echo $e_mail;?>"></a><?php }?>
						<?php if($vine){?><a class="social social-icon vine" href="<?php echo $vine;?>"></a><?php }?>
						<?php if($myspace){?><a class="social social-icon myspace" href="<?php echo $myspace;?>"></a><?php }?>
						<?php if($goodreads){?><a class="social social-icon goodreads" href="<?php echo $goodreads;?>"></a><?php }?>
						<?php if($apple){?><a class="social social-icon apple" href="<?php echo $apple;?>"></a><?php }?>
						<?php if($windows){?><a class="social social-icon windows" href="<?php echo $windows;?>"></a><?php }?>
						<?php if($yelp){?><a class="social social-icon yelp" href="<?php echo $yelp;?>"></a><?php }?>
						<?php if($playstation){?><a class="social social-icon playstation" href="<?php echo $playstation;?>"></a><?php }?>
						<?php if($xbox){?><a class="social social-icon xbox" href="<?php echo $xbox;?>"></a><?php }?>
						<?php if($android){?><a class="social social-icon android" href="<?php echo $android;?>"></a><?php }?>
						<?php if($ios){?><a class="social social-icon ios" href="<?php echo $ios;?>"></a><?php }?>
						
					</div>
					<?php }else{?>
						<div class="item"><?php echo do_shortcode($column1);?></div>
					<?php }?>
				</div>
				<?php }?>
				<?php if($column2){?>
					<div class="<?php echo $column_type;?>"><div class="item"><?php echo do_shortcode($column2);?></div></div>
				<?php }?>
				<?php if($column3){?>
					<div class="<?php echo $column_type;?>"><div class="item"><?php echo do_shortcode($column3);?></div></div>
				<?php }?>
				<?php if($column4){?>
					<div class="<?php echo $column_type;?>"><div class="item"><?php echo do_shortcode($column4);?></div></div>
				<?php }?>
			</div>
		</div>
	</div>
	<?php }?>