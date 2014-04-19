<?php
/**
 * Smarty modifier that adds pagination params to url link
 * @author Andrej Farkas <a.farkas@pixvalley.com>
 * @param int $iPageNumber 
 * @param string $sPaginationKey
 * @return string
 */
function smarty_modifier_pagination_url($iPageNumber, $sPaginationKey = 'p')
{    
    $oCI = get_instance();    
    
    $aPaginationParams = array(
        $sPaginationKey => $iPageNumber,
    );        
    
    $aGetParams = $oCI->input->getUriParamsArray();    
    $aParams = $aPaginationParams + $aGetParams;        
    
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '?' . http_build_query($aParams);
}
