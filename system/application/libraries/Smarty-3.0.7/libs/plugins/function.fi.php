<?php

function smarty_function_fi($params, &$template) {
    
    // parameter "class" is optional
    if ( isset( $params['class'] ) )
        $sElementClass = $params['class'];
    
    $sElementName  = $params['i'];
    $CI =& get_instance();
    $aElement      = $CI->iform->aElements[$sElementName];
    
    switch ( $aElement['input_type'] ) {
        case 'text':
            $sRet = '<input type="text" name="' . $sElementName . '" id="' . $sElementName . '" value="';
            if (isset($aElement['rules']) && preg_match('#valid_date#i', $aElement['rules']) && !empty($aElement['value'])) {
                $sDateFormat = preg_replace('#.*valid_date\[(.*)]#i', '$1', $aElement['rules']);
                try {
                    $oDate = DateTime::createFromFormat($sDateFormat, $aElement['value']) ?: new DateTime($aElement['value']);
                    $sRet .= $oDate->format($sDateFormat);
                } catch (\Exception $e) {
                    $sRet .= $aElement['value'];
                    // handled elsewhere
                }
            } else {
                $sRet .= (isSet($aElement['value']) ? htmlspecialchars($aElement['value']) : '');
            }
            $sRet .= '" class="' . (isSet($sElementClass) ? $sElementClass : '') . '" '. ((isSet($aElement['disabled']) && $aElement['disabled']) ? 'disabled="disabled"' : '') .' '. ((isSet($aElement['readonly']) && $aElement['readonly']) ? 'readonly="readonly"' : '') .' />';
            break;
        case 'file':
            $sRet = '<input type="file" name="' . $sElementName . '[]" id="' . $sElementName . '" class="' . (isSet($sElementClass) ? $sElementClass : '') . '" '. ((isSet($aElement['disabled']) && $aElement['disabled']) ? 'disabled="disabled"' : '') .' />';
            break;
        case 'hidden':
            $sRet = '<input type="hidden" name="' . $sElementName . '" id="' . $sElementName . '" value="' . $aElement['value'] . '" class="' . (isSet($sElementClass) ? $sElementClass : '') . '" />';
            break;
        case 'submit':
//            $sRet = '<input type="submit" name="' . $sElementName . '" id="' . $sElementName . '" value="' . $aElement['value'] . '" class="' . (isSet($sElementClass) ? $sElementClass : '') . '" />';
            $sRet = '<button name="' . $sElementName . '" id="' . $sElementName . '" value="' . $aElement['value'] . '" class="btn btn-validate ' . (isSet($sElementClass) ? $sElementClass : '') . '" type="submit"><strong class="in-1">'. $aElement['value'] . '</strong></button>';
            break;
        case 'reset':
            $sRet = '<input type="reset" name="' . $sElementName . '" value="' . $aElement['value'] . '" class="' . (isSet($sElementClass) ? $sElementClass : '') . '" />';
            break;
        case 'textarea':
            $sRet = '<textarea name="' . $sElementName . '" id="' . $sElementName . '" cols="' . $aElement['cols'] . '" rows="' . $aElement['rows'] . '" class="' . (isSet($sElementClass) ? $sElementClass : '') . '" '. ((isSet($aElement['disabled']) && $aElement['disabled']) ? 'disabled="disabled"' : '') .'>';
            $sRet .= (isset($aElement['value']) ? $aElement['value'] : '');
            $sRet .= '</textarea>';
            break;
        case 'select':
            if (isset($aElement['selected']) && $aElement['selected'] === "0") {
                $aElement['selected'] = array(0=>0);
            } elseif (empty($aElement['selected'])) {
                $aElement['selected'] = array();
            }
            $sRet = '<select name="' . $sElementName . ((isset($aElement['multiple'])) ? '[]' : '') . '" id="' . $sElementName . '" class="' . (isset($aElement['multiple']) ? "custom-multi-select " : "custom-select " ) . (isset($sElementClass) ? $sElementClass : NULL) . '" '. ((isset($aElement['disabled']) && $aElement['disabled']) ? ' disabled="disabled"' : NULL) . (isset($aElement['multiple']) ? ' multiple="multiple" size="4"' : NULL) . ' >';
            foreach ($aElement['options'] as $optionIndex => $optionValue) {
                $sRet .= '<option value="' . $optionIndex . '"';
                if (is_array($aElement['selected']) && array_key_exists($optionIndex, $aElement['selected'])) {
                    $sRet .= ' selected="selected"';
                } elseif ($aElement['selected'] == $optionIndex) {
                    $sRet .= ' selected="selected"';
                }
                $sRet .= '>' . htmlspecialchars( (!empty( $optionValue ) ? _( $optionValue ) : $optionValue ) ) . '</option>';
            }
            $sRet .= '</select>';
            break;
        case 'checkbox':
            $sRet = '<input type="checkbox" name="' . $sElementName . '" id="' . $sElementName . '" value="' . (isset($aElement['value']) ? $aElement['value'] : '') . '" ' . ((isSet($aElement['checked']) && $aElement['checked']) ? 'checked="checked"' : '') . ' class="' . (isset($sElementClass) ? $sElementClass : '') . '" '. ((isset($aElement['disabled']) && $aElement['disabled']) ? 'disabled="disabled"' : '') .' />';
            break;
        case 'button':
            $sRet = '<button name="' . $sElementName . '" id="' . $sElementName . '" value="' . $aElement['value'] . '" class="btn btn-validate ' . (isSet($sElementClass) ? $sElementClass : '') . '" type="button"><strong class="in-1">'. $aElement['value'] . '</strong></button>';
            break;
        case 'image':
            // let's leave it untreated until needed
            break;
        
        default:
            die('wrong input_type @ form');
            break;
    }

    return $sRet;
}