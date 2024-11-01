<?php
declare( strict_types = 1 );


namespace kdaviesnz\wptimetoread;

/**
 * Class wptimetoread
 *
 * @package kdaviesnz\timetoread
 */
class WPTimeToRead implements IWPTimeToRead
{

	/**
	 * timetoread constructor.
	 */
	public function __construct() {

	}

	/**
	 * Code called after plugins are loaded.
	 *
	 * @return Callable
	 */
	public function onPluginsLoaded() :Callable {
		return function() {

			add_action( 'init', $this->init() );

            // Admin_menu hook is only fired when we're in admin.
            add_action( 'admin_menu', function() {
                $this->admin();
            } );

			// Admin CSS and Javascript.
			add_action( 'admin_head', $this->adminHead() );
			add_action( 'admin_footer', $this->adminFoot() );
			add_action( 'wp_head', $this->head() );
			add_action( 'wp_footer', $this->foot() );

			// Filters.
			add_filter( 'the_content', WPTimeToReadView::filterPost() );
		};
	}


	/**
	 * Code called when plugin is activated.
	 *
	 * @return Callable
	 */
	public function onActivation() :Callable {
		return function() {
			// Add code to be called on activation here.
		};
	}

	/**
	 * Code called when plugin id deactivated.
	 *
	 * @return Callable
	 */
	public function onDeactivation() :Callable {
		return function() {
			// Add code to be called on deactivation here.
		};
	}

	/**
	 * Code called when init action is fired.
	 *
	 * @return bool
	 */
	public function init() {
		return function() {
            // Meta boxes.
            add_action( 'add_meta_boxes', $this->metaBoxes( 'post' ) );
            add_action( 'add_meta_boxes', $this->metaBoxes( 'page' ) );
            return true;
		};
	}

    /**
     * Executed when admin_menu hook is fired.
     */
    public function admin() : bool {
        // Tables
        add_filter( 'manage_posts_columns', WPTimeToReadView::addPostsTableColumnHeader() );
        add_action( 'manage_posts_custom_column', WPTimeToReadView::addPostsTableColumnContent(), 10, 2 );
        add_filter( 'manage_pages_columns', WPTimeToReadView::addPostsTableColumnHeader() );
        add_action( 'manage_pages_custom_column', WPTimeToReadView::addPostsTableColumnContent(), 10, 2 );
        return true;
    }
	/**
	 * Code to generate html to go in the <head> tag on the admin pages.
	 */
	public function adminHead() {
		return function() {
			wp_register_style( 'timetoread_admin_css', dirname( plugin_dir_url( __FILE__ ) ) . '/css/timetoread_admin.css' );
			wp_enqueue_style( 'timetoread_admin_css' );
		};
	}

	/**
	 * Code to generate html to go in the footer of admin pages.
	 */
	public function adminFoot() {
		return function() {
			wp_enqueue_script( 'jquery' );
			wp_register_script( 'gsdom_js', dirname( plugin_dir_url( __FILE__ ) ) . '/js/gsdom.js' );
			wp_enqueue_script( 'gsdom_js' );
			wp_register_script( 'timetoread_admin_js', dirname( plugin_dir_url( __FILE__ ) ) . '/js/timetoread_admin.js' );

			// Localize the script with new data.
			global $post;
			if ( ! empty( $post ) ) {
				$params = array(
					'ajax_url' => admin_url() . 'admin-ajax.php',
				);
				wp_localize_script( 'timetoread_admin_js', 'timetoread_params', $params );
				// Enqueued script with localized data.
				wp_enqueue_script( 'timetoread_admin_js' );
			}
		};
	}

	/**
	 * Code to generate html to go in the <head> tag on the non-admin pages.
	 */
	public function head() {
		return function() {
			wp_register_style( 'wptimetoread_css', dirname( plugin_dir_url( __FILE__ ) ) . '/css/wptimetoread.css' );
			wp_enqueue_style( 'wptimetoread_css' );
		};
	}

	/**
	 * Code to generate html to go in the footer of non-admin pages.
	 */
	public function foot() {
		return function() {
			wp_enqueue_script( 'jquery' );
			wp_register_script( 'gsdom_js', dirname( plugin_dir_url( __FILE__ ) ) . '/js/gsdom.js' );
			wp_enqueue_script( 'gsdom_js ' );

			wp_register_script( 'timetoread_js', dirname( plugin_dir_url( __FILE__ ) ) . '/js/timetoread.js' );

			// Localize the script with new data.
			$params = array(
				'ajax_url' => admin_url() . 'admin-ajax.php',
				'home_url' => get_home_url(),
			);
			wp_localize_script( 'timetoread_js', 'timetoread_params', $params );
			// Enqueued script with localized data.
			wp_enqueue_script( 'timetoread_js' );
		};
	}

	/**
	 * Render setting fields on the timetoread page.
	 */
	public function metaBoxes( string $screen ) {
		return function () use ($screen) {
			// Ref: https://developer.wordpress.org/reference/functions/add_meta_box/.
			add_meta_box(
				'timetoread_settings',
				'Time to read',
				WPTimeToReadView::renderMetaboxes(),
				$screen,
				'normal',
				'high'
			);
			return true;
		};
	}

}
