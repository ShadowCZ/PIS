<?php
/**
 * Smarty modifier that adds pagination params to url link
 * @author Andrej Farkas <a.farkas@pixvalley.com>
 * @param int $iPageNumber 
 * @param string $sPaginationKey
 * @return string
 */
function smarty_modifier_page_switcher_url($iPagesCount, $sKey = 'pp')
{    
    $oCI = get_instance();    
    
    $aPaginationParams = array(
        $sKey => $iPagesCount,
    );        
    
    $aGetParams = $oCI->input->getUriParamsArray();    
    $aParams = $aPaginationParams + $aGetParams;        
    
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '?' . http_build_query($aParams);
}
