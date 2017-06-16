<?php

include_once('rss/rss.class.php');


# Используем имя сайта, если в запросе есть непустой параметр "site"
isset($_GET['site']) ? $RSS = new RSS($_GET['site']) : $RSS = new RSS();


if ($_GET['format'] == 'json') {
    header('Content-type:application/json;charset=utf-8');
    
    $arr = array(
		'speech' => "С сайта «".$RSS->getSiteTitle()."» (".$RSS->getSiteLink().")... \n\n".
					$RSS->getRssItemTitle()." (".$RSS->getRssItemLink()."): \n".
					$RSS->CleanUp_HTML($RSS->getRssItemText()), 
		//'displayText' => "", 
		//'data' => "", 
		//'contextOut' => "", 
		'source' => $RSS->getSiteRssUrl()
		);
	
	print_r(json_encode($arr));
}
else {
    header('Content-type:text/html;charset=utf-8');
    
    echo "<center><h1>Preview page</h1></center><br/>";
	echo "<h2>Site info</h2>";
    echo "<p><b>Title:</b> " . $RSS->getSiteTitle() . "</p>";
    echo "<p><b>URL:</b> " . $RSS->getSiteLink() . "</p>";
    echo "<p><b>RSS link:</b> " . $RSS->getSiteRssUrl() . "</p>";
    echo "<br />";
    echo "<h2>Item info</h2>";
    echo "<p><b>Title:</b> " . $RSS->getRssItemTitle() . "</p>";
    echo "<p><b>Link:</b> " . $RSS->getRssItemLink() . "</p>";
    echo "<p><b>Date:</b> " . $RSS->getRssItemDate()->format('Y.m.d H:i:s') . "</p>";
    echo "<p><b>Text:</b> <br />" . $RSS->getRssItemText() . "</p>";
}


?>