<?php
$keywords;
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }	

    return $ip;
}

if(isset($_POST["email"]) && strlen($_POST["email"]) > 0){
	$email = $_POST["email"];
	$ip = getUserIP();

	\App\Table\Everything::addEmail($email, $ip);
}
function site_head($title = null, $keywords = ""){ ?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo ($title == null) ? "Streawin - Better way to watch TV Shows" : $title . " - Streawin"  ?></title>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<meta name="propeller" content="63fed857ffc401451a01228b2cfc8692" />
	<meta name="description" content="Streawin is an easy way to watch TV Shows online">
	<meta name="keywords" content="streaming, streawin, watch, series, tv, shows, tv shows, show, tv show, popcorn, hd, online, free, Live Tv, Live Online, Internet Tv, Series Free, Series Online, Watch Internet, Show Stream<?php echo (count($keywords) > 0) ? ", " . implode(", ", $keywords) : "" ?>">
	<meta name="author" content="Streawin">
	<meta name="robots" content="index,follow"/>
	<meta http-equiv="content-language" content="en"/>

	<meta property="og:site_name" content="Streawin"/>
	<meta property="og:title" content="<?php echo ($title == null) ? "Streawin - Better way to watch TV Shows" : $title . " - Streawin"  ?>"/>
	<meta property="og:type" content="website"/>
	<meta property="og:image" content="http://streawin.com/fb.jpg"/>
	<meta property="fb:app_id" content="509128059270552"/>
	<meta property="og:url" content="http://strewin.com"/>
	<meta property="og:description" content="Streawin is an easy way to watch TV Shows online."/>

	<link rel="icon" type="image/png" href="<?php echo getFileURL('public' . DS . "dist" . DS . 'img' . DS . "favicon.png") ?>">
	<!-- STYLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo getFileURL('public' . DS . "dist" . DS . 'css' . DS . "min" . DS . 'plugins.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo getFileURL('public' . DS . "dist" . DS . 'css' . DS . 'style.css') ?>">

	<!-- SCRIPTS -->
	<script type="text/javascript" src="<?php echo getFileURL('public' . DS . "dist" . DS . 'js' . DS . 'jquery.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo getFileURL('public' . DS . "dist" . DS . 'js' . DS . 'jquery.flexslider-min.js') ?>"></script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '1677900009142336');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1677900009142336&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
</head>
<body>
<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '509128059270552',
			xfbml      : true,
			version    : 'v2.6'
		});
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

<!-- HEADER -->
<header class="main_header">
	<div class="left">
		<a class="logo" href="<?php echo getLink(""); ?>"><img src="<?php echo getFileURL("public" . DS . "dist" . DS . "img" . DS . "logo.png") ?>" alt="logo"></a>
	</div>
	<div class="right">
		<nav class="main_nav">
			<ul>
				<li><a href="<?php echo getLink("") ?>">home</a></li>
				<li><a href="<?php echo getLink("contact") ?>">contact us</a></li>
			</ul>
		</nav>
			<ul class="social_icons header" style="float:right;padding:15px 20px">
				<li><a href="https://www.facebook.com/streatchTv" target="_blank"><i class="icon ion-social-facebook"></i></a></li>
				<li><a href="https://twitter.com/streawin_" target="_blank"><i class="icon ion-social-twitter"></i></a></li>
				<li><a href="http://instagram.com/streawin" target="_blank"><i class="icon ion-social-instagram"></i></a></li>
			</ul>
	</div>
</header>

<!-- SIDEBAR -->
<div class="left">
	<div class="main_sidebar">
		
		<form action="#" method="post">
			<div class="input_1">
				<input type="text" placeholder="search..." name="search" class="search">
				<button type="submit" class="btn_2"><i class="icon ion-search"></i></button>
			</div>
		</form>
		<ul class="list_1" style="margin-bottom:30px; float:left">
			<li>
				<a href="" class="categories_link">
					<i class="icon ion-android-list"></i>
					<span>categories <i class="icon ion-arrow-down-b"></i></span>
				</a>
				<div class="categories_menu">
					<?php 
					$categories = \App\Table\Everything::getGenres()->fetchAll();
					$cats = [];
					foreach($categories as $c){
						$cc = explode(",", $c->genres);
						foreach($cc as $ccc){
							array_push($cats, $ccc);
						}
					}
					$cats = array_unique($cats);
					?>

					<ul>
						<?php foreach($cats as $c): ?>
						<li><a href="<?php echo getLink("category", ["category"=>$c]) ?>"><?php echo str_replace("-", " ", $c); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</li>
			<li>
				<a href="<?php echo getLink("contact") ?>">
					<i class="icon ion-plus"></i>
					<span>suggest a tv show</span>
				</a>
			</li>
			<li>
				<a href="" class="disclaimer_link">
					<i class="icon ion-alert"></i>
					<span>disclaimer</span>
				</a>
			</li>
		</ul>

		<div class="title_1" style="float:left;width:100%">newsletter</div>
		<form action="#" method="post" style="float:left;width:100%">
			<div class="input_1">
				<input type="text" placeholder="Your email..." name="email">
				<button type="submit" class="btn_2 sub_email"><i class="icon ion-arrow-right-c"></i></button>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	(function(d, w, jq){
		jq(d).ready(function(){
			var test;
			jq(".search").on("keyup", function(e){
				test = false;
				var self = jq(this);
				setTimeout(function(){
					if ( !test && self.val().length > 0 ){
						$.ajax({
							type : "post",
							url  : "/index.php?p=search&r=true",
							data : {
								"name_series" : self.val().toLowerCase()
							},
							success : function(data){
								$(".search_result").remove();
								$("body").append(data);
							}
						});
					}
					test = true;
				}, 1000);

			});


			jq(".sub_email").on("click", function(e){
				var input = jq(this).prev("input");
				var reg = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;

				if(!reg.test(input.val())){
					e.preventDefault();
					alert("Invalid email, please try again.");
				}
			});
		});
	})(document, window, jQuery);
</script>
<?php } ?>