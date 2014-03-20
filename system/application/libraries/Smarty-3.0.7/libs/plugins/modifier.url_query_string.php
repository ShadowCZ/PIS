<?php

/**
 * Returns valid query string given the string parameters
 * Appends new parameters and replaces any existing with new values
 * @author Andrej Farkas <a.farkas@pixvalley.com>
 * @param type $sParams
 * @return type 
 */
function smarty_modifier_url_query_string($sParams)
{
    $oCI = get_instance();
    $aParams = array();
    parse_str($sParams, $aParams);
    
    $aGetParams = $oCI->input->getUriParamsArray();
    parse_str($_SERVER['QUERY_STRING'], $aGetParams);
    $aParams = $aParams + $aGetParams;    
    
    return http_build_query($aParams);
}
