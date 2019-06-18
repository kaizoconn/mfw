<?php

// ----------------------------------------------------------------------------
// Allow pages and posts to have featured images
// ----------------------------------------------------------------------------
add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );

// ----------------------------------------------------------------------------
// Register menu
// ----------------------------------------------------------------------------
add_action( 'after_setup_theme', 'register_gmfw_menu' );

function register_gmfw_menu() {
	register_nav_menu( 'primary', __( 'Primary Menu', 'gmfw-main-menu' ) );
}

// ----------------------------------------------------------------------------
// gmfw_twocol - s/c to set up a two-column section
// ----------------------------------------------------------------------------
function gmfw_twocol( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'col'=> 0,
		), $atts));

	$return_string = ''; // init so that further lines can use .= notation consistently

	// if col is not specified or anything other than 1 or 2, return an error
	if ( empty($col) || ( ( $col != 1 ) && ( $col != 2 ) ) ) {
		$return_string .= '<pre>ERROR - GMFW_TWOCOL: The [col] parameter must be specified and either be [1] or [2].</pre>';
		return $return_string;
	}

	switch ( $col ) {
		case '1';
			$return_string .= '<table class="twocol"><tbody><tr><td class="left">';
			$return_string .= do_shortcode($content);
			$return_string .= '</td>';
		break;

		case '2';
			$return_string .= '<td class="right">';
			$return_string .= do_shortcode($content);
			$return_string .= '</td></tr></tbody></table>';
		break;

	}

	return $return_string;

}

add_shortcode('gmfw_twocol','gmfw_twocol');


// ----------------------------------------------------------------------------
// gmfw_view_blog - s/c to list all blog entries in a ul/li
// ----------------------------------------------------------------------------
function gmfw_view_blog( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'limit' => 5,
		), $atts));

	$return_string = ''; // init so that further lines can use .= notation consistently

	// if no limit is specified, default to 5 (5+1 = 6)
	if ( empty($limit) ) {
		// limit is 1-n
		$limit = 6;
	}

	$args = array(
	  'post_type' => 'post',
	  'post_status' => 'publish',
	  'orderby' => 'date',
	  'order' => 'desc',
	  'posts_per_page' => $limit, // -1 for all, 1-n for n posts
	  'tax_query' => array(
	  		array(
	  			'taxonomy' => 'category',
	  			'field' => 'slug',
	  			'terms' => 'blog'
	  		)
	  )
	);

	$my_query = null;
	$my_query = new WP_Query($args);

	$i = 0;

	if( $my_query->have_posts() ) {

		$return_string .= '<!-- query limit = ' . $limit . ' -->';
		$return_string .= '<ul class="blank">';

	  while ($my_query->have_posts()) : $my_query->the_post();

			/*
			// get a custom field from the current post
			$postMeta = get_post_custom_values("wpcf-upload-ad");
			$promoGraphic = $postMeta[0];
			*/
			$postDate = get_the_date("Y-m-d");

			$postPermalink = get_the_permalink();
			$postTitle = get_the_title();
			$postID = get_the_ID();

			/* DEBUG */
			/*
			$return_string .= "<pre>";
			$return_string .= "Permalink = [" . $postPermalink . "]<br>";
			$return_string .= "Title = [" . $postTitle . "]<br>";
			$return_string .= "ID = [" . $postID ."]<br>";
			$return_string .= "</pre>";
			*/

			$return_string .= '<li>';
			$return_string .= '<a href="' . $postPermalink . '">' . $postTitle . '</a> (' . $postDate . ')';
			$return_string .= '</li>';

			$i++;

	  endwhile;

		$return_string .= '</ul>';

	} else {

		$return_string .= '<p>No posts found.</p>';

	}

	wp_reset_postdata();  // Restore global post data stomped by the_post().

	return $return_string;

}

add_shortcode('gmfw_view_blog','gmfw_view_blog');


// ----------------------------------------------------------------------------
// gmfw_list_tweets - Lists tweets in a simple text-only format.
// Requires the [oAuth Twitter Feed for Developers] plugin
// ----------------------------------------------------------------------------

function gmfw_list_tweets( $atts ) {

	extract(shortcode_atts(array(
		'limit' => 5,
		), $atts));

	$screenname = 'gaelanlloyd';
	$options = '';

	$return_string = ''; // init so that further lines can use .= notation consistently

	$tweets = getTweets($screenname, $limit, $options);

	// Example code adapted from https://github.com/stormuk/storm-twitter-for-wordpress/wiki/Example-code-to-layout-tweets

	if(is_array($tweets)) {

		$return_string .= '<ul class="blank">';

		foreach($tweets as $tweet) {

		    if($tweet['text']) {
		        $the_tweet = $tweet['text'];

		        //
		        // NOTE:
		        // I've decided to comment out the majority of this functionality
		        // as I just want a plain text list of tweets where the entire
		        // tweet text links to the tweet page.
		        //

		        /*
		        Twitter Developer Display Requirements
		        https://dev.twitter.com/terms/display-requirements

		        2.b. Tweet Entities within the Tweet text must be properly linked to their appropriate home on Twitter. For example:
		          i. User_mentions must link to the mentioned user's profile.
		         ii. Hashtags must link to a twitter.com search with the hashtag as the query.
		        iii. Links in Tweet text must be displayed using the display_url
		             field in the URL entities API response, and link to the original t.co url field.
		        */

		        // i. User_mentions must link to the mentioned user's profile.
		        /*
		        if(is_array($tweet['entities']['user_mentions'])) {
		            foreach($tweet['entities']['user_mentions'] as $key => $user_mention) {
		                $the_tweet = preg_replace(
		                    '/@'.$user_mention['screen_name'].'/i',
		                    '<a href="http://www.twitter.com/'.$user_mention['screen_name'].'" target="_blank">@'.$user_mention['screen_name'].'</a>',
		                    $the_tweet);
		            }
		        }
		        */

		        // ii. Hashtags must link to a twitter.com search with the hashtag as the query.
		        /*
		        if(is_array($tweet['entities']['hashtags'])) {
		            foreach($tweet['entities']['hashtags'] as $key => $hashtag){
		                $the_tweet = preg_replace(
		                    '/#'.$hashtag['text'].'/i',
		                    '<a href="https://twitter.com/search?q=%23'.$hashtag['text'].'&src=hash" target="_blank">#'.$hashtag['text'].'</a>',
		                    $the_tweet);
		            }
		        }
		        */

		        // iii. Links in Tweet text must be displayed using the display_url
		        //      field in the URL entities API response, and link to the original t.co url field.
		        /*
		        if(is_array($tweet['entities']['urls'])) {
		            foreach($tweet['entities']['urls'] as $key => $link) {
		                $the_tweet = preg_replace(
		                    '`'.$link['url'].'`',
		                    '<a href="'.$link['url'].'" target="_blank">'.$link['url'].'</a>',
		                    $the_tweet);
		            }
		        }
		        */

		        $return_string .= '<li><a href="https://twitter.com/' . $screenname . '/status/'.$tweet['id_str'].'" target="_blank">' . $the_tweet . '</a></li>';

		        // 3. Tweet Actions
		        //    Reply, Retweet, and Favorite action icons must always be visible for the user to interact with the Tweet. These actions must be implemented using Web Intents or with the authenticated Twitter API.
		        //    No other social or 3rd party actions similar to Follow, Reply, Retweet and Favorite may be attached to a Tweet.
		        // get the sprite or images from twitter's developers resource and update your stylesheet
		        /*
		        echo '
		        <div class="twitter_intents">
		            <p><a class="reply" href="https://twitter.com/intent/tweet?in_reply_to='.$tweet['id_str'].'">Reply</a></p>
		            <p><a class="retweet" href="https://twitter.com/intent/retweet?tweet_id='.$tweet['id_str'].'">Retweet</a></p>
		            <p><a class="favorite" href="https://twitter.com/intent/favorite?tweet_id='.$tweet['id_str'].'">Favorite</a></p>
		        </div>';
				*/

		        // 4. Tweet Timestamp
		        //    The Tweet timestamp must always be visible and include the time and date. e.g., “3:00 PM - 31 May 12”.
		        // 5. Tweet Permalink
		        //    The Tweet timestamp must always be linked to the Tweet permalink.
		        /*
		        echo '
		        <p class="timestamp">
		            <a href="https://twitter.com/' . $screenname . '/status/'.$tweet['id_str'].'" target="_blank">
		                '.date('h:i A M d',strtotime($tweet['created_at']. '- 8 hours')).'
		            </a>
		        </p>';// -8 GMT for Pacific Standard Time
		        */

		    } else {

		    	$return_string .= '<li>No tweets found.</li>';

		    }

		}

	$return_string .= '</ul>';

	}

	return $return_string;

}

add_shortcode('gmfw_list_tweets','gmfw_list_tweets');


// ----------------------------------------------------------------------------
// Set archives to show X posts per page
// ----------------------------------------------------------------------------
/*
function post_count_archive( $query ) {
    if( !is_admin() && $query->is_main_query() && is_archive() ) {
        $query->set( 'posts_per_page', '4' );
    }
}
add_action( 'pre_get_posts', 'post_count_archives' );
*/


// ----------------------------------------------------------------------------
// Category archive pagination fix
// Fixes 404 when custom permalink string is: /%category%/%postname%/
// Adapted from: https://wordpress.org/plugins/category-pagination-fix/faq/
// ----------------------------------------------------------------------------

function remove_page_from_query_string($query_string) {
    if (@$query_string['name'] == 'page' && isset($query_string['page'])) {
        unset($query_string['name']);
        list($delim, $page_index) = explode('/', $query_string['page']);
        $query_string['paged'] = $page_index;
    }
    return $query_string;
}
add_filter('request', 'remove_page_from_query_string');

// following are code adapted from Custom Post Type Category Pagination Fix by jdantzer
function fix_category_pagination($qs) {
	if(isset($qs['category_name']) && isset($qs['paged'])){
		$qs['post_type'] = get_post_types($args = array(
			'public'   => true,
			'_builtin' => false
		));
		array_push($qs['post_type'],'post');
	}
	return $qs;
}
add_filter('request', 'fix_category_pagination');

// ----------------------------------------------------------------------------
// Empty P and BR tag remover
// Tidies up undesirable P and BR tags from the GMFW_COL shortcode content
// Adapted from: https://thomasgriffin.io/remove-empty-paragraph-tags-shortcodes-wordpress/
// ----------------------------------------------------------------------------

// add_filter( 'the_content', 'tgm_io_shortcode_empty_paragraph_fix' );

/**
 * Filters the content to remove any extra paragraph or break tags
 * caused by shortcodes.
 *
 * @since 1.0.0
 *
 * @param string $content  String of HTML content.
 * @return string $content Amended string of HTML content.
 */
function tgm_io_shortcode_empty_paragraph_fix( $content ) {

	$array = array(
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']'
	);
	return strtr( $content, $array );

}

// --- Disable unused WP features ----------------------------------------------

// --- Disable adjacent post prefetch

remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

// --- Disable wp-embed.min.js

function wsh_deregister_wp_scripts() {
  wp_deregister_script( 'wp-embed' );
}

add_action( 'wp_footer', 'wsh_deregister_wp_scripts' );

// --- Disable wp-emoji-release.min.js

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// --- Remove <link rel='shortlink'>
// which causes tons of useless pages to be followed during a wget operation

remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

// --- Remove <meta name="generator">

remove_action('wp_head', 'wp_generator');

// --- Return H1 / Page SEO title ----------------------------------------------

function gmfw_return_page_title() {

	if ( is_category() ) {
		$title = single_cat_title( NULL, FALSE );
	} elseif ( is_tag() ) {
		$title = "Posts tagged: " . single_tag_title();
	} elseif ( is_author() ) {
		$title = "Posts by: " . get_the_author_meta('display_name');
	} elseif ( is_day() ) {
		$title = "Daily archives: " . get_the_time('l, F j, Y');
	} elseif ( is_month() ) {
	    $title = "Monthly archives: " . get_the_time('F Y');
	} elseif ( is_year() ) {
	    $title = "Yearly archives: " . get_the_time('Y');
	} else {
		$title = get_the_title();
	}

	return $title;

}