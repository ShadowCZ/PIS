<?php

function smarty_function_fl($params, &$template) {
    $sElementName = $params['i'];
    $sRet = '';
    $CI =& get_instance();
    if (array_key_exists($sElementName, $CI->iform->aElements)) {
        $sRet = $CI->iform->aElements[$sElementName]['label'];
        $sRet = '<label for="' . $sElementName . '" class="' . (isSet($params['class']) ? $params['class'] : '') . '">' . $sRet;
        // required items
        if( isset($CI->iform->aElements[$sElementName]['rules']) &&
            substr_count( $CI->iform->aElements[$sElementName]['rules'], 'required') > 0 ){
           $sRet .= ' *';
        }
        
        $sRet .= '</label>';
    }
    return $sRet;
}