<?php
/**
Plugin Name: WPTimeToRead
Description: Displays in minutes the time to read a post or page based not only on the number of words but the difficulty.
Version: 1.0.0
Author: Kevin Davies
License: GPLv2 or later
 *
 * @package kdaviesnz/wptimetoread
 */

declare( strict_types = 1 );

set_time_limit( 0 );

require_once( 'vendor/autoload.php' );
require_once( 'vendor/kdaviesnz/timetoread/src/ITimeToRead.php' );
require_once( 'vendor/kdaviesnz/timetoread/src/TimeToRead.php' );


require_once( 'src/iwptimetoread.php' );
require_once( 'src/wptimetoread.php' );
require_once( 'src/iwptimetoreadview.php' );
require_once( 'src/wptimetoreadview.php' );
require_once( 'src/iwptimetoreadmodel.php' );
require_once( 'src/wptimetoreadmodel.php' );

$wpt = new \kdaviesnz\wptimetoread\WPTimeToRead();

/*
 Note: plugins_loaded hook is fired after the Wordpress files including the user's activated plugins are loaded
but before pluggable functions and Wordpress starts executing anything. It's the earliest plugin we can use
and hence our starting point.
 */
add_action( 'plugins_loaded', $wpt->onPluginsLoaded() );

register_activation_hook( __FILE__, $wpt->onActivation() );

register_deactivation_hook( __FILE__, $wpt->onDeactivation() );

