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
			$sMessage = '<div class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
				<p>
					<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					<strong>Error: </strong>'. $sTitle .'<br>'. $sMessage .' 
				</p>
			</div>';
			break;

		case MSG_WRG:
			$sMessage = '<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
				<p>
					<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					<strong>Warning: </strong>'. $sTitle .'<br>'. $sMessage .'
				</p>
			</div>';
			break;

		case MSG_INF:
			$sMessage = '<div class="ui-state-active ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
				<p>
					<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					<strong>Info: </strong>'. $sTitle .'<br>'. $sMessage .'
				</p>
			</div>';
			break;
	}
        
	$CI->s->assign('message', $sMessage);
}

