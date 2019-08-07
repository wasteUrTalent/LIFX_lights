<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="content-language" content="zh-Hant"/>
	<meta name="viewport" content="width=device-width">

<!-- meta -->
	<title>Lights</title><!-- 自定 -->
	<meta property="og:site_name" content="" />
	<meta property="og:title" content="" /><!-- 自定 -->
	<meta name="description" property="og:description" content="" /><!-- 自定 -->
	<meta property="og:type" content="website" />

<!-- ico -->
<!-- 	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
-->

<!-- css -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
	
<!--[if lte IE 8]>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-old-ie-min.css">
<![endif]-->
<!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css">
<!--<![endif]-->

	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/1.4.14/jquery.scrollTo.min.js"></script>

</head>

<style>
.pure-g [class *="pure-u"] {font-family: 'Noto Sans', sans-serif;}
.light-list {padding: 0; margin: 0;}
.light-list li {padding: 10px;}
.light-list li div {vertical-align: middle;}
.offline {opacity: .5;}
.online i {color: #86BB71;}
.label {margin: 0 8px;}
.label+span { color: #666; font-size: 12px;}


.switches {
  position: relative; display: block;
  width: 3.5em; height: 1.5em;
  cursor: pointer;
  border-radius: 1.5em;
  transition: 350ms;
  background: #ddd;
  float: right;
}

.switches::after {
  position: absolute; content:'';
  width: 1em; height: 1em;
  top: 0.25em; left: 0.25em;
  border-radius: 1.5em;
  transition:
    width 200ms ease-out,
    height 300ms 50ms ease-in,
    top 300ms 50ms ease-in,
    left 250ms 50ms ease-in,
    background 300ms ease-in,
    box-shadow 300ms ease-in;
  background: #f2f2f2;
  box-shadow: 0 0 0 1.5em #f2f2f2 inset;
}

input:checked + .switches::after {
  width: 2em; height: 1.5em;
	top: 0; left: 1.5em;
  background: #4c6;
  box-shadow: 0 0 0 0 #f2f2f2 inset;
}
.switches-input { display: none;}
</style>

<body>
<!-- start -->

<header>
</header>

<section>
<?php
$options = array( 
			CURLOPT_RETURNTRANSFER => true,
			// CURLOPT_HEADER => false,
			// CURLOPT_FOLLOWLOCATION => true,
			// CURLOPT_ENCODING => 'UTF-8',
			// CURLOPT_USERAGENT => $user_agent,
			// CURLOPT_AUTOREFERER => true,
			// CURLOPT_CONNECTTIMEOUT => 120,
			// CURLOPT_TIMEOUT => 120,
			// CURLOPT_MAXREDIRS => 10,
			// CURLOPT_SSL_VERIFYHOST => 0,
			// CURLOPT_SSL_VERIFYPEER => false, 
			// CURLOPT_VERBOSE => 1
		); 

$link = "https://api.lifx.com/v1/lights/all";
$authToken = "{{token}}}";
$ch = curl_init($link);
$headers = array('Authorization: Bearer ' . $authToken);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);



	curl_setopt_array($ch, $options);
	$content = curl_exec($ch); 

	$err = curl_errno($ch); 
	$errmsg = curl_error($ch) ; 
	$header = curl_getinfo($ch);

	curl_close($ch); 

	// var_dump(json_decode($content, true));
	$array = json_decode($content, true);
?>
<ul class="light-list pure-g">
<?php
	foreach ($array as $v) {
		echo '<li class="pure-u-1 pure-u-sm-1-2 pure-u-md-1-3 ';
		if ($v["connected"]==false) {
			echo 'offline';
		} elseif ($v["connected"]==true) {
			echo 'online';
		}
		echo '"><div class="pure-g">
		<div class="pure-u-2-3"><i class="fa fa-cloud"></i><span class="label">'.$v["label"].'</span><span>'.$v["location"]["name"].' - '.$v["group"]["name"].'</span></div>
		<div class="pure-u-1-3">
		<input class="switches-input" type="checkbox" id="'.$v["id"].'" ';

		if ($v["connected"]==true) {
			if ($v["power"]==on) {
				echo 'checked';
			}
			echo '/>
			<label class="switches" for="'.$v["id"].'""></label>';
		}
		echo '</div></div>
		</li>';
	} 
?>
</ul>

</section>

<footer>
</footer>

<script>
$(document).ready(function() {
$(".switches-input").change(function(){
var cID = $(this).attr("id")
console.log(cID);
  $.ajax({
    url:"script.php", 
    type: "POST",
    data: {cID:cID},
    beforeSend:function(){
    	$('#' + cID).prop('disabled', true);
    },
    success:function(result){
    	$('#' + cID).prop('disabled', false);
    }
  });
});
})
</script>

<!-- end -->
</body>
</html>