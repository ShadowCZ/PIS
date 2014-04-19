<?php
/**
 * Smarty modifier that adds sorting params to url link
 * @author Andrej Farkas <a.farkas@pixvalley.com>
 * @param string $sSortByAttributeName
 * @param string $sDefaultSort
 * @return string
 */
function smarty_modifier_sort_url($sSortByAttributeName, $sFilterKey = MY_Input::DEFAULT_FILTER_IDENTIFIER, $sDefaultSort = MY_Model::SORT_ASC)
{    
    $oCI = get_instance();
    $aFilter = $oCI->input->getUriParam($sFilterKey);
    $aSort = array(
        $sSortByAttributeName => $sDefaultSort,
    );
    
    if (isset($aFilter[MY_Input::SORT_IDENTIFIER][$sSortByAttributeName]))
    {
        $aSort[$sSortByAttributeName] = MY_Model::SORT_ASC;
        if ($aFilter[MY_Input::SORT_IDENTIFIER][$sSortByAttributeName] == MY_Model::SORT_ASC)
        {
            $aFilter[MY_Input::SORT_IDENTIFIER][$sSortByAttributeName] = MY_Model::SORT_DESC;
        } 
        else
        {
            $aFilter[MY_Input::SORT_IDENTIFIER][$sSortByAttributeName] = MY_Model::SORT_ASC;            
        }
    }
    else
    {
        $aFilter[MY_Input::SORT_IDENTIFIER] = array(
            $sSortByAttributeName => $sDefaultSort,
        );
    }
    
    $aGetParams = $oCI->input->getUriParamsArray();    
    $aParams = array( $sFilterKey => $aFilter) + $aGetParams;        
    
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '?' . http_build_query($aParams);
}
