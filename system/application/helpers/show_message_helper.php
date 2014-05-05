<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define("MSG_ERR", 1);
define("MSG_WRG", 2);
define("MSG_INF", 3);
/**
 * Show error message
 *
 * @author Radim Res
 * @param $iType 1-general error, 2-form warning, 3-info message
 * @param $sTitle title
 * @param $sMessage message
 * @param $mDesc description 
 */

function show_message($iType, $sTitle, $sMessage = null, $mDesc = null) {

	$CI = & get_instance(  );
	
	switch ($iType) {
		case MSG_ERR:
			$sMessage = '<div class="alert alert-danger">
					<strong>Chyba: </strong>'. $sTitle .'<br>'. $sMessage .'
			</div>';
			break;

		case MSG_WRG:
			$sMessage = '<div class="alert alert-warning">
					<strong>Upozornění: </strong>'. $sTitle .'<br>'. $sMessage .'
			</div>';
			break;

		case MSG_INF:
			$sMessage = '<div class="alert alert-info">
					<strong>Info: </strong>'. $sTitle .'<br>'. $sMessage .'
			</div>';
			break;
	}
        
	$CI->s->assign('message', $sMessage);
}

