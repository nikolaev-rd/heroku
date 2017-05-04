<?php

// Number of quotes, from which quote will be selected random
$quotes_number = 100;

// checking for JSON is valid or not
function isValidJSON($JSON_string) { 
	json_decode($JSON_string); 
	return (json_last_error() === JSON_ERROR_NONE); 
} 

//$url = "http://umori.li/api/get?site=bash.im&num=$quotes_number";
$url = "http://umori.li/api/random?num=$quotes_number";

$contents = file_get_contents($url); // get json string from $url

if (isValidJSON($contents)) {
	$json=json_decode($contents, true);
	
	header('Content-type:application/json;charset=utf-8'); // setup header options

	$n=rand(0,$quotes_number-1); // select one quote from array

	$json[$n]["elementPureHtml"] = htmlspecialchars_decode($json[$n]["elementPureHtml"], ENT_NOQUOTES); //decode characters in text, exclude quotes (it's important for JSON format)
	$json[$n]["elementPureHtml"] = str_replace("&quot;", "'", $json[$n]["elementPureHtml"]); // replace quotes
	$json[$n]["elementPureHtml"] = str_replace("&laquo;", "«", $json[$n]["elementPureHtml"]); // replace quotes
	$json[$n]["elementPureHtml"] = str_replace("&raquo;", "»", $json[$n]["elementPureHtml"]); // replace quotes
	$json[$n]["elementPureHtml"] = str_replace("&amp;", "&", $json[$n]["elementPureHtml"]); // replace ampersand
	$json[$n]["elementPureHtml"] = str_replace("&nbsp;", " ", $json[$n]["elementPureHtml"]); // replace space
	$json[$n]["elementPureHtml"] = str_replace("\n ", "\n", $json[$n]["elementPureHtml"]); // replace space in the begining of the line
	$json[$n]["elementPureHtml"] = str_replace("<p>", "\n", $json[$n]["elementPureHtml"]); // replace start of paragrapf
	$json[$n]["elementPureHtml"] = strip_tags($json[$n]["elementPureHtml"]); // remove other HTML tags
	$json[$n]["elementPureHtml"] = str_replace("&copy;", "©", $json[$n]["elementPureHtml"]); // replace copyright symbol
	$json[$n]["elementPureHtml"] = str_replace("&trade;", "™", $json[$n]["elementPureHtml"]); // replace copyright symbol
	$json[$n]["link"] = str_replace("/url.html?url=", "", $json[$n]["link"]); // remove API URL prefix
	$json[$n]["link"] = rawurldecode($json[$n]["link"]); // decode for correct http url in text

	if ($json[$n]["link"] != null) {
		$link = "(".$json[$n]["link"].")";
	} 
	else{
		if ($json[$n]["site"] != null) {
			$link = "(".$json[$n]["site"].")";	
		}
	}

	$arr = array(
		'speech' => "Случайная цитата с сайта ".$json[$n]["desc"]." ".$link.": \n\n".$json[$n]["elementPureHtml"], 
		//'displayText' => "Random quote from ".$json[$n]["name"]."(".$json[$n]["link"]."):\n ".$json[$n]["elementPureHtml"], 
		//'data' => "", 
		//'contextOut' => "", 
		'source' => $json[$n]["site"]
		);
		
	print_r(json_encode($arr));
}
else {
	echo "ERROR: JSON from $url isn't correct! Please try again later...";
}

?>