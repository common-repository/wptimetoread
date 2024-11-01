<?php
declare( strict_types = 1 );


namespace kdaviesnz\wptimetoread;
use kdaviesnz\timetoread\TimeToRead;

/**
 * Class WPTimeToReadView
 *
 * @package kdaviesnz\wptimetoread
 */
class WPTimeToReadView implements IWPTimeToReadView
{

	/**
	 * Code to filter post content.
	 *
	 * @return Callable
	 */
	public static function filterPost() :Callable {
		return function( $content ) {
            $t = new TimeToRead( $content );
            if ( 1 >= $t->getMinutes() ) {
                $text = '<p class="wptimetoread">Estimated reading time one minute or less.</p>';
            } else {
                $text = '<p class="wptimetoread">Estimated reading time ' . $t->getMinutes() . ' minute(s).</p>';
            }
			return $text . $content;
		};
	}

	public static function addPostsTableColumnHeader() :Callable {
        return function( array $defaults ) {
            $defaults["Reading time"] = "Reading time";
            return $defaults;
        };
    }

    public static function addPostsTableColumnContent() :Callable {
        return function( string $column_name, int $post_ID ) {
            if ( "Reading time" == $column_name ) {
                $post = get_post( $post_ID );
                $t = new TimeToRead( $post->post_content );
                if ( 1 >= $t->getMinutes() ) {
                    echo 'One minute or less';
                } else {
                    echo $t->getMinutes() . ' minute(s).';
                }
            }
        };
    }

    /**
     * Render meta boxes.
     *
     * @return bool
     */
    public static function renderMetaboxes() :Callable {
        return function ( $post ) {
            $t = new TimeToRead( $post->post_content );
            if ( 1 >= $t->getMinutes() ) {
                $text = '<p>Time to read: One minute or less.</p>';
            } else {
                $text = '<p>Time to read: ' . $t->getMinutes() . ' minute(s).</p>';
            }
            _e(
                $text,
                'template'
            );
        };
    }
}
