<?php
/*
Plugin Name: Google Analytics by JDSpiral
Plugin URI:  http://jdspiral.com
Description: This plugin display Google Analytics Information
Version:     1.0
Author:      Josh Hathcock
Author URI:  http://jdspiral.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: ga-jds
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

include_once( plugin_dir_path(__FILE__) . 'admin/admin.php');
include_once( plugin_dir_path(__FILE__) . 'admin/options.php');


/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function jds_ga_add_dashboard_widgets() {

	wp_add_dashboard_widget(
                 'jds_ga_dashboard_widget',         // Widget slug.
                 'Google Analytics Dashboard Widget',         // Title.
                 'jds_ga_dashboard_widget_function' // Display function.
        );

	// Align Dashboard Widget to right side
	// Global the $wp_meta_boxes variable (this will allow us to alter the array).
	global $wp_meta_boxes;

	// Then we make a backup of your widget.
	$my_widget = $wp_meta_boxes['dashboard']['normal']['core']['jds_ga_dashboard_widget'];

	// We then unset that part of the array.
	unset($wp_meta_boxes['dashboard']['normal']['core']['jds_ga_dashboard_widget']);

	// Now we just add your widget back in.
	$wp_meta_boxes['dashboard']['side']['core']['jds_ga_dashboard_widget'] = $my_widget;
	}
	add_action( 'wp_dashboard_setup', 'jds_ga_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function jds_ga_dashboard_widget_function() {?>
	<!-- Step 1: Create the containing elements. -->

	<!-- Step 1: Create the containing elements. -->

<section id="auth-button"></section>
<section id="view-selector"></section>
<section id="timeline"></section>

<!-- Step 2: Load the library. -->

<script>
(function(w,d,s,g,js,fjs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
  js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
}(window,document,'script'));
</script>

<script>
gapi.analytics.ready(function() {

  // Step 3: Authorize the user.

  var CLIENT_ID = '511408457597-p1ino2qdb2dpimsjfjm8jjukkt1162ih.apps.googleusercontent.com';

  gapi.analytics.auth.authorize({
    container: 'auth-button',
    clientid: CLIENT_ID,
  });

  // Step 4: Create the view selector.

  var viewSelector = new gapi.analytics.ViewSelector({
    container: 'view-selector'
  });

  // Step 5: Create the timeline chart.

  var timeline = new gapi.analytics.googleCharts.DataChart({
    reportType: 'ga',
    query: {
      'dimensions': 'ga:date',
      'metrics': 'ga:sessions',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
    },
    chart: {
      type: 'LINE',
      container: 'timeline'
    }
  });

  // Step 6: Hook up the components to work together.

  gapi.analytics.auth.on('success', function(response) {
    viewSelector.execute();
  });

  viewSelector.on('change', function(ids) {
    var newIds = {
      query: {
        ids: ids
      }
    }
    timeline.set(newIds).execute();
  });
});
</script><?php
}