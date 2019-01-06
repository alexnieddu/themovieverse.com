<?php
session_start();
$hot = 0;
?>
<!DOCTYPE html>
<html lang="en"  prefix="og: http://ogp.me/ns# fb: http://www.facebook.com/2008/fbml">
<head>
	<script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>
	<meta charset="utf-8">
	<meta name="description" content="The Movieverse is a Social Movie Database which provides a comprehensive collection of related movie data organized for convenient access including the sense of social interactions." >
	<meta name="p:domain_verify" content="6cd0989e07ff84a5b256d902a1c8bb7e"/>
	<!-- 01. Mai 2012 
	Movieverse is a web-platform where you get all informations of movies.
				News, reviews and ratings are all stored in one page to make it more easier for you. Follow some movies to get
				updated with the latest news.
	-->
    
    <meta property="og:title" content="Movieverse" >
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://themovieverse.com" >
	<meta property="og:image" content="http://themovieverse.com/images/screens/movieverse-about.png" />
	<meta property="og:site_name" content="Movieverse" >
	
	<meta property="twitter:card" content="summary" />
	<meta property="twitter:site" content="@_movieverse" />
	<meta property="twitter:title" content="Movieverse" />
	<meta property="twitter:description" content="Your Social Movie Database" />
	<meta property="twitter:image" content="http://themovieverse.com/images/screens/movieverse-about.png" />
	<meta property="twitter:url" content="http://themovieverse.com" />
    
    <title>Movieverse: Your social movie database</title>
	<link rel="shortcut icon" href="/images/logo/movieverse_icon_small_fav.png" type="image/x-icon" >
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	<link rel="canonical" href="http://themovieverse.com/">
	
	<?php require 'config.php'; ?>
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
	
	<style type="text/css">
	.fb_connect {
	background-color: #43609b;background: -webkit-linear-gradient(#5678bc, #314a7b);background: linear-gradient(#5678bc, #314a7b);
	border: 1px solid #293f69;
	border-top-color: #314a7b;
	color: #fff;
	text-shadow: 0 1px #444;cursor:pointer; font-size:12px; width:90%; margin: 15px 10px; height:15px;}
	</style>
<script type="application/ld+json">
{ "@context" : "http://schema.org",
  "@type" : "Organization",
  "name" : "Movieverse",
  "url" : "http://themovieverse.com",
  "sameAs" : [ "https://www.facebook.com/movieverse.de",
    "https://twitter.com/_movieverse",
    "https://plus.google.com/+Movieverse-de",
    "https://www.pinterest.com/movieverse"] 
}
</script>

<script type="application/ld+json">
{
"@context": "http://schema.org",
"@type": "WebSite",
"url": "http://themovieverse.com/",
"potentialAction": {
"@type": "SearchAction",
"target": "http://themovieverse.com/search.php?q={search_term}",
"query-input": "required name=search_term"
}
}
</script>
	
</head>
<body>
<?php include_once("analyticstracking.php"); ?>
<?php include("header.php"); ?>
<div id="main" class="js-masonry" data-masonry-options='{ "columnWidth": 10, "itemSelector": ".item" }'>
	<?php
	if(!isset($_SESSION["userid"]))
	{
	/*?>
	<div class="kachel item">
		<div class="login">
			<h2>Sign In</h2>
			<form method="POST" action="?user=log">
				<ul class="list-block">
					<li>
						<input class="input-login" type="text" name="email" value="" placeholder="Email" />
					</li>
					<li>
						<input class="input-login" type="password" name="passwort" value="" placeholder="Password" />
					</li>
					<li>
						<input style="width:90%" type="submit" class="login-btn" value="Sign In" />
					</li>
					<?php
					if($fb_url)
					{
					?>
					<li>
						<div style="position:relative;height:10px;width:88%;">
							<div style="position:absolute;top:10px;left:0px;height:1px;width:40%;background:grey;"></div>
							<div style="position:absolute;top:0px;left:48%;">or</div>
							<div style="position:absolute;top:10px;right:0px;height:1px;width:40%;background:grey;"></div>
						</div>
					</li>
					<li>
						<a class="fb_style login-btn" href="<?php echo $fb_url; ?>"><img style="position:relative;width:26px;margin:0px;padding:0px;top:8px;left:-6px;" width="26" height="26" src="images/icons/F_icon.png" alt="Facebook Anmeldung" > Sign in with Facebook</a>
					</li>
					<?php
					}
					?>
					<li>
						<a class="regist-login" href="/regist">Join for free.</a>
					</li>
					<li>
						<a class="regist-login" href="/repassword.php">Forgot your password?</a>
					</li>
				</ul>
			</form>
		</div>
	</div>
	<?php
	*/}
	/* Array mit FilmIDs, die auf Watchlist sind */
	if(isset($_SESSION["userid"]))
	{
	$id_user = $_SESSION["userid"];
	$k = 1;
	$abfrage = "SELECT id, titel, big, user_relate.status FROM film, user_relate WHERE film.aktiv = 'Ja' AND user_relate.id_film = film.id AND user_relate.id_user = $id_user AND user_relate.status = 1";
	$ergebnis = mysql_query($abfrage);
	$menge = mysql_num_rows($ergebnis);
		while($row = mysql_fetch_object($ergebnis))
		{
		$film_id_array[$k] = $row->id;
		$k++; 
		}
	}
	
	$k = 1;
	if(isset($_SESSION["userid"]))
	{
	$abfrage = "SELECT id, titel, big, user_relate.status FROM film, user_relate WHERE film.aktiv = 'Ja' AND user_relate.id_film = film.id AND user_relate.id_user = $id_user AND user_relate.status = 1";
	/*$abfrage1 = "SELECT id_film AS id, film.titel, SUM(c1)
FROM
(
(
SELECT v2.id_film, COUNT(*)*2 AS c1
    FROM  votes v
    LEFT  OUTER  JOIN votes v1 ON v1.id_film = v.id_film
    LEFT  OUTER  JOIN votes v2 ON v1.user = v2.user
    WHERE v.user = $id_user
    AND v1.user != $id_user
    AND v.bewertung > 6
AND v1.bewertung >= v.bewertung
AND v2.bewertung >= v.bewertung
GROUP BY id_film
)
UNION
(
SELECT id_film, COUNT(*) AS c1
FROM tags_relate tr
WHERE id_tag IN
(
SELECT id_tag
FROM tags_relate tr
WHERE id_film IN
(
SELECT id_film
FROM bewertung_besucher bb
INNER JOIN bewertung_besucher_relate bbr ON bb.id = bbr.id_bewertung_besucher
WHERE bb.user = $id_user
AND bb.bewertung > 6
)
)
GROUP BY id_film
)
) u1
INNER JOIN film ON film.id = u1.id_film
WHERE id_film NOT IN
(
SELECT id_film
FROM votes v
WHERE user = $id_user
)
GROUP BY u1.id_film
ORDER BY SUM(c1) DESC, kinostart DESC LIMIT 30";*/
	}
	else
	{
	$abfrage = "SELECT DISTINCT film.id, film.titel, film.originaltitel, kinostart, big, news.id AS news_id, news.wann, news.titel AS newstitel FROM film INNER JOIN news ON news.id_film = film.id WHERE aktiv = 'Ja' AND public = 'Ja' AND news.wann < $timestamp ORDER BY news.wann DESC LIMIT 30";
	//$abfrage = "SELECT film.id, film.titel, film.originaltitel, kinostart, big, news.wann FROM film INNER JOIN news ON news.id_film = film.id WHERE aktiv = 'Ja' AND public = 'Ja' AND kinostart > ($timestamp-(604800*16)) ORDER BY news.wann DESC LIMIT 30";
	}
	$abfrage = "SELECT DISTINCT film.id, film.titel, film.originaltitel, kinostart, big, news.id AS news_id, news.wann, news.titel AS newstitel FROM film INNER JOIN news ON news.id_film = film.id WHERE aktiv = 'Ja' AND public = 'Ja' AND news.wann < $timestamp ORDER BY news.wann DESC LIMIT 30";
	$abfrage = "SELECT DISTINCT film.id, film.titel, film.originaltitel, kinostart, big, news.id AS news_id, news.wann, news.titel AS newstitel, likes, ABS(UNIX_TIMESTAMP(NOW()) - news.wann)/3600, ( (likes + 1) /( ABS(UNIX_TIMESTAMP(NOW()) - news.wann)/3600)) AS r
FROM news
INNER JOIN film ON news.id_film = film.id
WHERE aktiv = 'Ja' AND public = 'Ja' AND news.wann < UNIX_TIMESTAMP(NOW())
ORDER BY r DESC LIMIT 30";
	$ergebnis = mysql_query($abfrage);
	$film_id_news = array();
	while($row = mysql_fetch_object($ergebnis))
	{
	$id_film = $row->id;
	$filmtitel = utf8_encode("$row->titel");
	$originaltitel = utf8_encode("$row->originaltitel");
	$shortn_filmtitel = strtodir($filmtitel);
	$url_film = '/'.$shortn_filmtitel.'-'.$id_film;
	$big = $row->big;
	$kinostart = $row->kinostart;
	$newstime = $row->wann;
			if($k == 0)
			{
			?>
			<div style="height:650px;" class="kachel item big">
			<h2>Visit Movieverse's profile on Pinterest.</h2>
			<div style="position:relative;left:7px;"><a data-pin-do="embedUser" href="http://www.pinterest.com/movieverse/pins/" data-pin-scale-height="420" data-pin-board-width="410">Visit Movieverse's profile on Pinterest.</a></div>
			</div>
			<?php
			}
			//6
			if($k == 0)
			{
			?>
			<div class="kachel item big">
				<a href="./themoviedetectionrule">
					<img src="./images/juicy_movie_statistics_infographic_small.jpg" width="410" alt="Infographic of Movie Statistics" title="Juicy Movie Statistics">
				</a>
				<div class="info_1">
					<div class="margin">
						<h3 style="font-size:20px; ">Movie Detection Rule</h3>
						<span style="font-weight:normal; color:white;">What characteristics indicate a good movie and how actors and directors rank.</span>
					</div>
				</div>
			</div>
			<?php
			}
			if($k == 3)
			{
			?>
			<div class="kachel item big">
				<h2 class="center medium">In Theaters</h2>
				<ul class="kachel_list">
					<?php
					$abfrage5 = "SELECT id, titel, opener, kinostart, boxoffice, gross FROM film WHERE kinostart BETWEEN ($timestamp - 604800*3) AND $timestamp AND aktiv = 'Ja' AND typ = 'film' ORDER BY kinostart LIMIT 5";
					$ergebnis5 = mysql_query($abfrage5);
					$menge5 = mysql_num_rows($ergebnis5);
					while($row5 = mysql_fetch_object($ergebnis5))
					{
					$filmname = utf8_encode($row5->titel);
					$filmopener = utf8_encode($row5->opener);
					$soon = "$row5->kinostart";
					$boxoffice = utf8_encode($row5->boxoffice);
					$gross = utf8_encode($row5->gross);
					?>
					<li class="center">
						<a class="normal_font bold" href="./<?php echo strtodir($filmname); ?>-<?php echo $row5->id; ?>"><?php echo $filmname; ?></a>
						<br/>
						<span class="small_font normal">Boxoffice: <?php if($boxoffice) echo substr($boxoffice, 0, -12).'k'; else echo '-';?></span>
						 · 
						<span class="small_font normal">Total Gross: <?php if($gross) echo substr($gross, 0, -12).'k'; else echo '-';?></span>
					</li>
					<?php
					}
					?>
				</ul>
			</div>
			<?php
			}
			if($k == 5)
			{
			?>
			<div class="kachel item ">
				<h2 class="center medium">Upcoming</h2>
				<ul class="kachel_list">
					<?php
					$abfrage5 = "SELECT id, titel, kinostart FROM film WHERE kinostart BETWEEN $timestamp AND ($timestamp + 604800*3) AND aktiv = 'Ja' AND typ = 'film' ORDER BY kinostart LIMIT 7";
					$ergebnis5 = mysql_query($abfrage5);
					$menge5 = mysql_num_rows($ergebnis5);
					while($row5 = mysql_fetch_object($ergebnis5))
					{
					$filmname = utf8_encode($row5->titel);
					$soon = "$row5->kinostart";
					?>
					<li class="center">
						<a class="small_font" href="./<?php echo strtodir($filmname); ?>-<?php echo $row5->id; ?>"><?php echo $filmname; ?></a>
					</li>
					<?php
					}
					?>
					<li class="center active">
						<a class="small_font" href="./upcoming">SEE ALL</a>
					</li>
				</ul>
			</div>
			<?php
			}
			
			
			
			
			if($k == 0 )
			{
			?>
			<div class="kachel item big">
				<h2 class="center bold">Feed</h2>
				<ul class="kachel_list">
					<?php
					$abfrage5 = "SELECT news.id AS newsID, news.titel AS newstitel, news.text, film.id AS filmID, film.titel AS filmtitel FROM news INNER JOIN film ON film.id = news.id_film WHERE public = 'Ja' AND news.wann < $timestamp ORDER BY wann DESC LIMIT 5";
					$ergebnis5 = mysql_query($abfrage5);
					$menge5 = mysql_num_rows($ergebnis5);
					while($row5 = mysql_fetch_object($ergebnis5))
					{
					$filmID = $row5->filmID;
					$titel_film_feed = utf8_encode($row5->filmtitel);
					$newsID = $row5->newsID;
					$titel_news_feed = utf8_encode($row5->newstitel);
					$opener_news_feed = utf8_encode($row5->text);
					$soon = "$row->wann";
					$shortn_titel_film_feed = strtodir($titel_film_feed);
					$shortn_titel_news_feed = strtodir($titel_news_feed);
					$url_feed = '/'.$shortn_titel_film_feed.'-'.$filmID.'#news'.$newsID;
					?>
					<li class="center">
						<span><a href="<?php echo $url_feed; ?>" class="normal_font bold"><?php echo $titel_news_feed; ?></a></span>
					</li>
					<?php
					}
					?>
				</ul>
			</div>
			<?php
			}
			if($k == 0)
			{
			?>
			<a href="./goldenglobes2015">
			<div class="kachel item opacity big" style="font-weight:normal; text-align:center; background:#3986D3; color:#FFF;">
				<h2 style="font-weight:bold; color:#FFF;">Golden Globes</h2>
				<p style="text-align:center;">Check out the Golden Globes winners of 2015.</p>
			</div>
			</a>
			<?php
			}
			if($k == 3 AND isset($id_user))
			{
			?>
			<a href="./suggest">
			<div class="kachel item opacity big" style="font-weight:normal; text-align:center; background:#0F791E; color:#FFF;">
				<h2 style="color:#FFF;" class="medium">Suggest</h2>
				<p style="text-align:center;">Individual Movie Recommendation<br/>Based on Your Likes.</p>
			</div>
			</a>
			<?php
			}
			if($k == 6)
			{
			?>
			<a href="./selector">
			<div class="kachel item big opacity" style="font-weight:normal; text-align:center; background:#2D4A67; color:#FFF;">
				<h2 style="color:#FFF;" class="medium">Selector</h2>
				<p style="text-align:center;">Find the Right Movie for the Right Rood.</p>
			</div>
			</a>
			<?php
			}
			if($k == 3)
			{
			?>
			<a href="http://kinu-app.com" target="_blank">
			<div class="kachel item big opacity" style="font-weight:normal; text-align:center; background:#0B4C5F; color:#FFF;">
				<h2 style="color:#FFF;" class="medium">Kinu App</h2>
				<p style="text-align:center;">Individual Movie Recommendations</p>
			</div>
			</a>
			<?php
			}
			if($k == 3 AND isset($id_user))
			{
			?>
			<a href="./help">
			<div class="kachel item opacity big" style="font-weight:normal; text-align:center; background:#1274D7; color:#FFF;">
				<h2 style="color:#FFF;" class="medium">Helpcenter</h2>
				<p style="text-align:center;">You need a little Help?<br/>Visit our Helpcenter for How To's.</p>
			</div>
			</a>
			<?php
			}
			if($k == 0)
			{
			?>
			<a href="./listofchristmasmovies">
			<div class="kachel item opacity" style="font-weight:normal; text-align:center; background:#4D8F33; color:#FFF;">
				<h2 style="font-weight:bold; color:#FFF;">Christmas Movies</h2>
				<p style="text-align:center;">List of christmas movies.</p>
			</div>
			</a>
			<?php
			}
			
			if($k == 0 AND !isset($id_user))
			{
			?>
			<a href="./about">
			<div class="blue_kachel kachel item big opacity" style="font-weight:normal; text-align:center;">
				<h2 style="color:white;" class="bold">Your Social Movie Db</h2>
				<p class="web_title" style="text-align:center; font-size:18px;">The Movieverse is a <strong>Social Movie Database</strong> which provides a comprehensive collection of related movie data organized for convenient access including the sense of <strong>social interactions</strong>.</p>
			</div>
			</a>
			<?php
			}
			
		if( !in_array($id_film, $film_id_news) )
		{	
		?>
		<div class="kachel item <?php /*if( $k == 1 AND !isset($_SESSION["userid"]) ) echo 'big';*/ ?>">
			<div class="badges">
				<?php
				if($kinostart <= $timestamp && $kinostart >= ($timestamp - 1814400))
				{
				echo '<span class="cine-badge">Now Playin\'</span>';
				}
				$abfrage_news = "SELECT id FROM news WHERE news.id_film = $id_film AND news.wann <= $timestamp AND news.wann >= ($timestamp - 432000) AND public = 'Ja'";
				$ergebnis_news = mysql_query($abfrage_news);
				$menge_news = mysql_num_rows($ergebnis_news);
				if( $menge_news != 0)
				{
				/*?>
				<a href="/<?php echo strtodir($filmtitel); ?>-<?php echo $row->id; ?>#news"><span class="news-badge">News</span></a>
				<?php */
				}
				?>
			</div>
			<a href="./<?php echo strtodir($filmtitel); ?>-<?php echo $row->id; ?>">
				<?php image($id_film,1,0); ?>
			</a>
			<?php
			if(isset($_SESSION["userid"]))
			{
				if( $menge == 0 )
				{
				?>
				<button class="watchlist-btn login-btn shadow add"><span class="glyphicon glyphicon-plus"></span> watchlist</button>
				<?php
				}
				else
				{
					if( in_array($id_film, $film_id_array) )
					{
					?>
					<button class="watchlist-btn login-btn shadow delete">remove <span class="glyphicon glyphicon-remove"></span></button>
					<?php
					}
					else
					{
					?>
					<button class="watchlist-btn login-btn shadow add"><span class="glyphicon glyphicon-plus"></span> watchlist</button>
					<?php
					}
				}
			}
			
			$abfrage_news = "SELECT * FROM news WHERE id_film = $id_film";
			$ergebnis_news = mysql_query($abfrage_news);
			$menge_news = mysql_num_rows($ergebnis_news);
			
			$abfrage_watcher = "SELECT * FROM user_relate WHERE id_film = $id_film";
			$ergebnis_watcher = mysql_query($abfrage_watcher);
			$menge_watcher = mysql_num_rows($ergebnis_watcher);
			
			
			if($k < 6) echo '<div class="info_1">';
			else echo '<div class="info">';
			?>
				<div class="margin">
					<h3><?php echo $filmtitel; ?></h3>
					<?php
					echo '<span><a style="font-weight:normal; color:white;" href="'.$url_film.'#news'.$row->news_id.'">'.utf8_encode($row->newstitel).'</a></span>';
					?>
					<!--
					<ul class="list" style="position:relative;margin-left:60%;">
						<?php
						if($menge_watcher != 0)
						{
						?>
						<li>
							<span title="Watcher" class="glyphicon glyphicon-heart"></span> <?php echo $menge_watcher; ?>
						</li>
						<?php
						}
						if($menge_news)
						{
						?>
						<li>
							<span title="News" class="glyphicon glyphicon-comment"></span> <?php echo $menge_news; ?>
						</li>
						<?php
						}
						?>
					</ul>
					-->
				</div>
			</div>
			<span class="<?php echo $id_film; ?>" style="display:none;"></span>
		</div>
		<?php
		}
	$film_id_news[$k] = $row->id;
	$k++; 
	}
	
	/*$abfrage = "SELECT film.id, film.titel, film.originaltitel, kinostart, bewertung, big FROM film WHERE aktiv = 'Ja' ORDER BY RAND() LIMIT 0";
	$ergebnis = mysql_query($abfrage);
	while($row = mysql_fetch_object($ergebnis))
	{
	$id_film = $row->id;
	$filmtitel = utf8_encode("$row->titel");
	$originaltitel = utf8_encode("$row->originaltitel");
	$big = $row->big;
	$kinostart = $row->kinostart;
	$newstime = $row->wann;
		if( !in_array($id_film, $film_id_news) )
		{
		?>
		<div class="kachel item <?php if( $big == 1 ) echo 'big'; ?>">
			<div class="badges">
				<?php
				if($kinostart <= $timestamp && $kinostart >= ($timestamp - 1814400))
				{
				echo '<span class="cine-badge">Now Playin\'</span>';
				}
				$abfrage_news = "SELECT * FROM news WHERE news.id_film = $id_film AND news.wann <= $timestamp AND news.wann >= ($timestamp - 432000) AND public = 'Ja'";
				$ergebnis_news = mysql_query($abfrage_news);
				$menge_news = mysql_num_rows($ergebnis_news);
				if( $menge_news != 0)
				{
				?>
				<a href="/<?php echo strtodir($filmtitel); ?>-<?php echo $row->id; ?>#news"><span class="news-badge">News</span></a>
				<?php
				}
				?>
			</div>
			<a href="/<?php echo strtodir($filmtitel); ?>-<?php echo $row->id; ?>">
				<?php image($filmtitel,1,0); ?>
			</a>
			<?php
			if(isset($_SESSION["userid"]))
			{
				if( $menge == 0 )
				{
				?>
				<button class="watchlist-btn login-btn shadow add">&#10010; watchlist</button>
				<?php
				}
				else
				{
					if( in_array($id_film, $film_id_array) )
					{
					?>
					<button class="watchlist-btn login-btn shadow delete">delete &#10006;</button>
					<?php
					}
					else
					{
					?>
					<button class="watchlist-btn login-btn shadow add">&#10010; watchlist</button>
					<?php
					}
				}
			}
			
			$abfrage_news = "SELECT * FROM news WHERE id_film = $id_film";
			$ergebnis_news = mysql_query($abfrage_news);
			$menge_news = mysql_num_rows($ergebnis_news);
			
			$abfrage_watcher = "SELECT * FROM user_relate WHERE id_film = $id_film";
			$ergebnis_watcher = mysql_query($abfrage_watcher);
			$menge_watcher = mysql_num_rows($ergebnis_watcher);
			
			
			?>
			<div class="info">
				<div class="margin">
					<h3><?php echo $originaltitel; ?><span style="color:yellow;"><?php if( $row->bewertung != 0) echo ' · <span title="Bewertung" style="border:1px solid grey; border-radius:2px; padding:1px 3px; font-weight:normal;">'.$row->bewertung.'</span>'; ?></span></h3>
					<!--
					<ul class="list">
						<li>
							Watcher: <?php echo $menge_watcher; ?>
						</li>
						<li>
							|
						</li>
						<li>
							News: <?php echo $menge_news; ?>
						</li>
					</ul>
					-->
				</div>
			</div>
			<span class="<?php echo $id_film; ?>" style="display:none;"></span>
		</div>
		<?php
		}
	}*/
	?>

</div>

<script src="js/jquery.js"></script>
<script src="js/masonry.pkgd.js"></script>
<?php require("javascripts.php"); ?>
<!-- watchlist adder -->
<script type="text/javascript">
$(document).ready(function() {
    $(".delete").click(function(){
		var action = 'delete';
		var film = $(this).parent("div").children("span").attr("class");
		$.ajax({
			type: "GET",
			url: "/ajax/watchlist.php",
			data: { action: action, id_film: film }
		});
		$(this).fadeOut(function() {
			$(this).text("success").css("background","green").css("border-color","darkgreen").fadeIn().delay(1000).fadeOut();
		});
	});
	 $(".add").click(function(){
		var action = 'add';
		var film = $(this).parent("div").children("span").attr("class");
		$.ajax({
			type: "GET",
			url: "/ajax/watchlist.php",
			data: { action: action, id_film: film }
		});
		$(this).fadeOut(function() {
			$(this).text("success").css("background","green").css("border-color","darkgreen").fadeIn().delay(1000).fadeOut();
		});
	});
});
</script>

<!-- InfiniteScroll -->
<script>
$(document).ready(function() {
	var i = 30;
	$(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() >= $(document).height()) {
	    	i += 10;
	    	$.ajax({
				type: "GET",
				url: "/scrollajax.php",
				data: { limit: i },
				success: function(kacheln) {
					var el = jQuery(kacheln);
					el.fadeIn(2000);
					$('.js-masonry').append(el);
					$('.js-masonry').masonry( 'reloadItems' );
					$('.js-masonry').masonry( 'layout' );
				}
			});
	   }
	});
});
</script>

<!-- Please call pinit.js only once per page
<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script> -->
</body>
</html>