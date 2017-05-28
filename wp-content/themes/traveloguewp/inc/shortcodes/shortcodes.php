<?php
/*------------------------------------------------------------------
[Travelogue - SHORTCODES]

Project:    Travelogue - Travel Blog WordPress Template 
Version:    1.0
Author:     Modeltheme
URL:        http://traveloguewp.modeltheme.com/

[Table of contents]

1. Recent Tweets
2. Recent Posts
3. Recent Portfolios
4. Services
5. Skills with Icons
6. Recent Testimonials
7. Call to Action 1
8. Contact Form
9. Pricing Table
10. Members
11. Call to Action 2
12. Columns
13. Image
14. Our main features
-------------------------------------------------------------------*/



/*---------------------------------------------*/
/*--- 1. Recent Tweets ---*/
/*---------------------------------------------*/
function travelogue_setup_shortcode_tweetslider( $params, $content ) {
    extract( shortcode_atts( array('title'=>'', 'no'=>''), $params ) );
    global $travelogue_redux_options;
	require_once( 'twitter/twitteroauth/twitteroauth.php' );
	# Get Theme Options Twitter Details
	$tw_username = $travelogue_redux_options['travelogue_social_tw'];
	$consumer_key = $travelogue_redux_options['travelogue_tw_consumer_key'];
	$consumer_secret = $travelogue_redux_options['travelogue_tw_consumer_secret'];
	$access_token = $travelogue_redux_options['travelogue_tw_access_token'];
	$access_token_secret = $travelogue_redux_options['travelogue_tw_access_token_secret'];
	$no = $no+1;
	# Create the connection
	$twitter = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
	# Migrate over to SSL/TLS
	$twitter->ssl_verifypeer = true;
	# Load the Tweets
	$tweets = $twitter->get('statuses/user_timeline', array('screen_name' => $tw_username, 'exclude_replies' => 'true', 'include_rts' => 'false', 'count' => $no));
	if(!empty($tweets)) {
		$tweets_list = "";
		$tweets_list .= '<div class="author_tweets_full white">';
		$tweets_list .= '<div class="boxed">';
		$tweets_list .= '<div class="one_sixth text-center"><i class="fa fa-twitter"></i></div>';
		$tweets_list .= '<div class="sixth_one">';
	    foreach($tweets as $tweet) {
	        # Access as an object
	        $tweetText = $tweet->text;
	        # Make links active
	        $tweetText = preg_replace("/(http:\/\/|(www.))(([^s<]{4,68})[^s<]*)/", '', $tweetText);
	        # Linkify user mentions
	        $tweetText = preg_replace("/@(w+)/", '', $tweetText);
	        # Linkify tags
	        $tweetText = preg_replace("/#(w+)/", '', $tweetText);
	 		
	 		$tweets_list .= '<span>@'.$tw_username.' - <i>'.$tweetText.'</i></span><div class="clearfix"></div>';
	    }
		$tweets_list .= '</div>';
	    $tweets_list .= '</div>';
	    $tweets_list .= '</div>';
	    return $tweets_list;
	}
}
add_shortcode('tweets', 'travelogue_setup_shortcode_tweetslider');


function travelogue_setup_shortcode_columns( $params, $content ) {
	extract( shortcode_atts( array('width'=>''), $params ) );
	$cols = array(
		'' => '',
		'1/2' => 'one_half',
		'1/3' => 'one_third',
		'1/4' => 'one_hour',
		'2/3' => 'two_third'
	);
    $icon = '<p class="'.$cols[$width].'">'.do_shortcode($content).'</p>';
    return $icon;
}
add_shortcode('column', 'travelogue_setup_shortcode_columns');



function travelogue_setup_shortcode_headings( $params, $content ) {
	extract( shortcode_atts( array('type'=>''), $params ) );
	$cols = array(
		'' => '',
		'h1' => 'h1',
		'h2' => 'h2',
		'h3' => 'h3',
		'h4' => 'h4',
		'h5' => 'h5',
		'h6' => 'h6'
	);
    $icon = '<'.$cols[$type].'>'.do_shortcode($content).'</'.$cols[$type].'>';
    return $icon;
}
add_shortcode('heading', 'travelogue_setup_shortcode_headings');


function travelogue_setup_shortcode_text_color( $params, $content ) {
	extract( shortcode_atts( array('color'=>''), $params ) );
	$cols = array(
		'' => '',
		'green' => 'green',
		'black' => 'black'
	);
    $icon = '<span class="'.$cols[$color].'">'.do_shortcode($content).'</span>';
    return $icon;
}
add_shortcode('text', 'travelogue_setup_shortcode_text_color');



function travelogue_setup_shortcode_dropcap( $params, $content ) {
	extract( shortcode_atts( array('color'=>'','content'=>''), $params ) );
	$cols = array(
		'' => '',
		'green' => 'green',
		'black' => 'black'
	);
    $icon = '<span class="firstcharacter '.$cols[$color].'">'.$content.'</span>';
    return $icon;
}
add_shortcode('dropcap', 'travelogue_setup_shortcode_dropcap');


function travelogue_setup_shortcode_blockquote( $params, $content ) {
	extract( shortcode_atts( array('content'=>''), $params ) );
         $blockquote = '<blockquote>'.$content.'</blockquote>';
        return $blockquote;
    }
add_shortcode('blockquote', 'travelogue_setup_shortcode_blockquote');



function travelogue_setup_shortcode_text_highlight( $params, $content ) {
	extract( shortcode_atts( array('content'=>''), $params ) );
        $shortcode_content = '<span class="highlight">'.$content.'</span>';
        return $shortcode_content;
    }
add_shortcode('text_highlight', 'travelogue_setup_shortcode_text_highlight');




function travelogue_setup_shortcode_icon( $params, $content ) {
	extract( shortcode_atts( array('icon'=>''), $params ) );
        $shortcode_content = '<i class="fa '.$icon.'"></i>';
        return $shortcode_content;
    }
add_shortcode('icon', 'travelogue_setup_shortcode_icon');



function travelogue_setup_shortcode_clearfix( $params, $content ) {
	extract( shortcode_atts( array('height'=>''), $params ) );
		$cols = array(
			'' => '',
			'5' => '5',
			'10' => '10',
			'15' => '15',
			'20' => '20',
			'25' => '25',
			'30' => '30',
			'50' => '50',
			'80' => '80'
		);
        $shortcode_content = '<div class="divider_'.$cols[$height].'"></div>';
        return $shortcode_content;
    }
add_shortcode('divider', 'travelogue_setup_shortcode_clearfix');





function travelogue_setup_shortcode_buttons( $params, $content ) {
	extract( shortcode_atts( 
		array(
			'text'			=> '',
			'dataeffect'	=> '',
			'style'			=> '',
			'size'			=> '',
			'url'			=> '',
			'color'			=> ''
		), $params ) );

        $shortcode_content = '<a data-effect="'.$dataeffect.'" href="'.$url.'" class="'.$style.' '.$size.' '.$color.'">'.$text.'</a>';
        return $shortcode_content;
    }
add_shortcode('button', 'travelogue_setup_shortcode_buttons');





function travelogue_setup_shortcode_tabs( $params, $content ) {
	extract( shortcode_atts( 
		array(
			'number_of_tabs' =>	'',
			'tab1_title'	 =>	'',
			'tab1_icon'		 =>	'',
			'tab1_content'	 =>	'',
			'tab2_title'	 =>	'',
			'tab2_icon'		 =>	'',
			'tab2_content'	 =>	'',
			'tab3_title'	 =>	'',
			'tab3_icon'		 =>	'',
			'tab3_content'	 =>	'',
			'tab4_title'	 =>	'',
			'tab4_icon'		 =>	'',
			'tab4_content'	 =>	'',
			'tab5_title'	 =>	'',
			'tab5_icon'		 =>	'',
			'tab5_content'	 =>	'',
		), $params ) );

	$shortcode_content = '';
	$shortcode_content .= '<div class="tabs tabs-style-topline nr_of_tabs'.$number_of_tabs.'">';
		#Tabs titles
	    $shortcode_content .= '<nav>';
	        $shortcode_content .= '<ul>';
	        	$shortcode_content .= '<li class="tab-current"><a href="#section-topline-1" class="fa '.$tab1_icon.'"><span>'.$tab1_title.'</span></a></li>';
	        	$shortcode_content .= '<li class=""><a href="#section-topline-2" class="fa '.$tab2_icon.'"><span>'.$tab2_title.'</span></a></li>';
	        	$shortcode_content .= '<li class=""><a href="#section-topline-3" class="fa '.$tab3_icon.'"><span>'.$tab3_title.'</span></a></li>';
	        	$shortcode_content .= '<li class=""><a href="#section-topline-4" class="fa '.$tab4_icon.'"><span>'.$tab4_title.'</span></a></li>';
	        	$shortcode_content .= '<li class=""><a href="#section-topline-5" class="fa '.$tab5_icon.'"><span>'.$tab5_title.'</span></a></li>';
	    	$shortcode_content .= '</ul>';
	    $shortcode_content .= '</nav>';
		#Tabs content
	    $shortcode_content .= '<div class="content-wrap">';
		    $shortcode_content .= '<section class="content-current" id="section-topline-1">'.$tab1_content.'<div class="clearfix"></div></section>';
		    $shortcode_content .= '<section id="section-topline-2">'.$tab2_content.'<div class="clearfix"></div></section>';
		    $shortcode_content .= '<section id="section-topline-3">'.$tab3_content.'<div class="clearfix"></div></section>';
		    $shortcode_content .= '<section id="section-topline-4">'.$tab4_content.'<div class="clearfix"></div></section>';
		    $shortcode_content .= '<section id="section-topline-5">'.$tab5_content.'<div class="clearfix"></div></section>';
		$shortcode_content .= '</div>';
	$shortcode_content .= '</div>';
        return $shortcode_content;
    }
add_shortcode('tabs', 'travelogue_setup_shortcode_tabs');
















/*---------------------------------------------*/
/*--- 8. Contact Form ---*/
/*---------------------------------------------*/
function travelogue_contact_form_shortcode($params, $content) {
	global $travelogue_redux_options;

	if (isset($_POST['q1'])) {
	    $to = $travelogue_redux_options['travelogue_contact_email'];
	    $subject = $_POST['q4'];
	    $form_user_name = $_POST['q1'];
	    $form_user_email = $_POST['q2'];
	    $form_comment = $_POST['q4'];

	    $message = '';
	    $message .= $form_comment . "\r\n" . "\r\n";
	    $message .= "From: " .  $form_user_name . "\r\n";
	    $message .= "Email: " . $form_user_email . "\r\n";
	    $message .= "Subject: " . $subject;

	    $headers = 'From: ' . $form_user_name . '<'. $form_user_email . '>';
	    if( wp_mail( $to, $subject, $message, $headers ) ) {
	        echo "<p>Your email has been sent! Thank you</p>";
	    }
	}

	$contact_form = '';
	$contact_form .= '<div>';
		$contact_form .= '<form method="POST" id="theForm" class="simform" autocomplete="off">';
			$contact_form .= '<div class="simform-inner">';
				$contact_form .= '<ol class="questions">';
					$contact_form .= '<li>';
					    $contact_form .= '<span><label for="q1">What is your name?</label></span>';
					    $contact_form .= '<input id="q1" class="focus-me" name="q1" type="text"/>';
					$contact_form .= '</li>';
					$contact_form .= '<li>';
					    $contact_form .= '<span><label for="q2">What is your email address?</label></span>';
					    $contact_form .= '<input id="q2" class="focus-me" name="q2" type="text"/>';
					$contact_form .= '</li>';
					$contact_form .= '<li>';
					    $contact_form .= '<span><label for="q3">What do you want to talk about?</label></span>';
					    $contact_form .= '<input id="q3" class="focus-me" name="q3" type="text"/>';
					$contact_form .= '</li>';
					$contact_form .= '<li>';
					    $contact_form .= '<span><label for="q4">Can you give me more details?</label></span>';
					    $contact_form .= '<textarea id="q4" name="q4" class="focus-me"></textarea>';
					$contact_form .= '</li>';
				$contact_form .= '</ol>';
				$contact_form .= '<button name="submit_contact" class="submit" type="submit">Send answers</button>';
				$contact_form .= '<div class="controls">';
					$contact_form .= '<button class="next"></button>';
					$contact_form .= '<div class="progress"></div>';
					$contact_form .= '<span class="number">';
						$contact_form .= '<span class="number-current"></span>';
						$contact_form .= '<span class="number-total"></span>';
					$contact_form .= '</span>';
					$contact_form .= '<span class="error-message"></span>';
				$contact_form .= '</div>';
			$contact_form .= '</div>';
			$contact_form .= '<span class="final-message"></span>';
		$contact_form .= '</form>';
	$contact_form .= '</div>';

	return $contact_form;
}
add_shortcode('contact_form', 'travelogue_contact_form_shortcode');









?>