<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// Include the CI's original url helper to avoid confusion.
include_once realpath( BASEPATH . 'helpers/url_helper.php' );

/**
 * Search the given uri string for a token, usually in format such as "token:<value>".
 * 
 * @param  string $sUriString
 * @param  string $sPrefix
 */
function url_token( $sUriString, $sPrefix ) {
    foreach ( explode( '/', $sUriString ) as $segment ) {
        if ( substr( $segment, 0, strlen( $sPrefix ) ) == $sPrefix )
            return substr( $segment, strlen( $sPrefix ), strlen( $segment ) - strlen( $sPrefix ) );
    }
    
    return NULL;
}



/**
 * Source URL
 *
 * Returns the "src_url" item from your config file
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('src_url'))
{
	function src_url()
	{
		$CI =& get_instance();
		return $CI->config->slash_item('src_url');
	}
}