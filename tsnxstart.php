<?php
//
// ScarySoftware RSS parser 
// Copyright (c) 2006 Scary Software
// ( Generates HTML from a RSS feeds )
//    
// Licensed Under the Gnu Public License
//

// Here are the feeds - you can add to them or change them
if (!isset($HTTP_GET_VARS['feedid'])) 
	$feedid = 0;
else 
	$feedid = $HTTP_GET_VARS['feedid'];
	
$RSSFEEDS = array(
	0 => "http://thepizzy.net/blog/?feed=rss2&cat=17",
	1 => "http://thespotnet:s0f7w0rks@twitter.com/statuses/user_timeline.xml",
	2 => "http://thepizzy.net/bluejournal/?feed=rss2"
);


//
//  Makes a pretty HTML page bit from the title, 
//  description and link
//
function FormatRow($title, $description, $link) {
return <<<HTML
<!-- RSS FEED ENTRY -->
<p class="feed_title" align="center">$title</p>
<p class="feed_description">$description</p>
<p align="center"><a class="feed_link" href="$link" rel="nofollow" target="_blank">Read more...</a></p>
<!-- END OF RSS FEED ENTRY -->

HTML;
}

// we'll buffer the output
ob_start();

// Now we make sure that we have a feed selected to work with
$rss_url = $RSSFEEDS[$feedid];

// Server friendly page cache
$ttl = 60*60;// 60 secs/min for 60 minutes = 1 hour(360 secs)  
$cachefilename = md5($rss_url);
if (file_exists($cachefilename) && (time() - $ttl < filemtime($cachefilename))) {
	// We recently did the work, so we'll save bandwidth by not doing it again
	include($cachefilename);
	exit();
}

// Now we read the feed
$rss_feed = file_get_contents($rss_url);

// Now we replace a few things that may cause problems later
$rss_feed = str_replace("<![CDATA[", "", $rss_feed);
$rss_feed = str_replace("]]>", "", $rss_feed);
$rss_feed = str_replace("\n", "", $rss_feed);


// Now we get the nodes that we're interested in
preg_match_all('#<title>(.*?)</title>#', $rss_feed, $title, PREG_SET_ORDER); 
preg_match_all('#<link>(.*?)</link>#', $rss_feed, $link, PREG_SET_ORDER);
preg_match_all('#<description>(.*?)</description>#', $rss_feed, $description, PREG_SET_ORDER); 

//
// Now that the RSS/XML is parsed.. Lets Make HTML !
//

// If there is not at least one title, then the feed was empty
// it happens sometimes, so lets be prepared and do something 
// reasonable
if(count($title) <= 1)
{
	echo "No news at present, please check back later.<br><br>";
}
else
{
    // OK Here we go, this is the fun part

    // Well do up the top 3 entries from the feed
	for ($counter = 1; $counter <= 1; $counter++ )
	{
	    // We do a reality check to make sure there is something we can show
		if(!empty($title[$counter][1]))
		{
		    // Then we'll make a good faith effort to make the title
			// valid HTML
			$title[$counter][1] = str_replace("&", "&", $title[$counter][1]);
			$title[$counter][1] = str_replace("&apos;", "'", $title[$counter][1]); 	

			// The description often has encoded HTML entities in it, and
			// we probably don't want these, so we'll decode them
			$description[$counter][1] =  html_entity_decode( $description[$counter][1]); 	

			// Now we make a pretty page bit from the data we retrieved from
			// the RSS feed.  Remember the function FormatRow from the 
			// beginning of the program ?  Here we put it to use.
			$row = FormatRow($title[$counter][1],$description[$counter][1],$link[$counter][1]);

			// And now we'll output the new page bit!
			echo $row;
		}
	}
}
				
// Finally we'll save a copy of the pretty HTML we just created
// so that we can skip most of the work next time
//$fp = fopen($cachefilename, 'w'); 
//fwrite($fp, ob_get_contents()); 
//fclose($fp); 

// All Finished!
ob_end_flush(); // Send the output to the browser

?>
