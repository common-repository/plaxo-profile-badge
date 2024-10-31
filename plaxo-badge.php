<?php
/*
Plugin Name: Plaxo Badge
Description: Put your Plaxo Badge on your Wordpress blog.
Author: plaxoMike
Version: 1.0

	This is a WordPress plugin (http://wordpress.org) and widget
	(http://automattic.com/code/widgets/).
*/

// We're putting the plugin's functions in one big function we then
// call at 'plugins_loaded' (add_action() at bottom) to ensure the
// required Sidebar Widget functions are available.


function widget_plaxo_init() {

	// Check to see required Widget API functions are defined...
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return; // ...and if not, exit gracefully from the script.

	// This function prints the sidebar widget--the cool stuff!
	function widget_plaxo($args) {

		// Collect our widget's options, or define their defaults.
		$options = get_option('widget_plaxo');
		$badge_code = $options['plaxobadgecode'];
	?>
	<div style="margin: 10px 0px">
	<? echo $badge_code ?>
	</div>
	<?php
	}

	// This is the function that outputs the form to let users edit
	// the widget's title and so on. It's an optional feature, but
	// we'll use it because we can!
	function widget_plaxo_control() {

		// Collect our widget's options.
		$options = get_option('widget_plaxo');
        if ( !is_array($options) )
			$options = array('plaxobadgecode'=>'');
		
		// This is for handing the control form submission.
		if ( $_POST['plaxo-submit'] ) {
			// Clean up control form submission options
			$options['plaxobadgecode'] = stripslashes($_POST['plaxo-badge-code']);
			update_option('widget_plaxo', $options);
		}

		// The HTML below is the control form for editing options.
?>
		<style type="text/css">
		.cssform p{
			text-align:left;
			margin:0px;
			padding:0px;
		}

		.cssform textarea {
			border:1px solid #448ABD;
			font-family:Arial,sans-serif;
			font-size:12px;
            width: 100%;
            height: 100px;
            margin-top:10px;
		}
		</style>
		<div class="cssform">
		  <p>
		  Help people find you on Plaxo by publishing a profile badge.
		  </p>
		  <p>
		  Setup your Plaxo badge:
		  <div style="margin-left: 10px">1. <a href="http://www.plaxo.com/pulse/settings/badge?src=wp" target="_blank">Click here</a> to access your badge settings page on Plaxo.</div>
		  <div style="margin-left: 10px">2. Copy the installation code on that page.</div>
		  <div style="margin-left: 10px">3. Paste the installation code into the box below.</div>
		  <div style="margin-left: 10px">4. Click the Change button.</div>
		<p>
		<textarea id="plaxo-badge-code" name="plaxo-badge-code"><?= $options['plaxobadgecode']; ?></textarea>
		</p>
		<input type="hidden" id="plaxo-submit" name="plaxo-submit" value="1" />
		</div>
	<?php
	// end of widget_plaxo_control()
	}

	// This registers the widget. About time.
	register_sidebar_widget('Plaxo Badge', 'widget_plaxo');

	// This registers the (optional!) widget control form.
	register_widget_control('Plaxo Badge', 'widget_plaxo_control', 300, 500);
}

// Delays plugin execution until Dynamic Sidebar has loaded first.
add_action('plugins_loaded', 'widget_plaxo_init');
?>
