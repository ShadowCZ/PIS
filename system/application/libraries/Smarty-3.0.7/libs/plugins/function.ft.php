<?php
   /**
     * function feed text
     * @author Petr Jurasek
     * @access Public
     * @return string
     */
function smarty_function_ft($params, &$template)
{
    $sElementName  = $params['i'];
    $CI =& get_instance();
    if (array_key_exists($sElementName, $CI->iform->aElements)) {
        $aElement  = $CI->iform->aElements[$sElementName];

         switch ( $aElement['input_type'] ) {

             case 'text':
                 if (isset($aElement['rules']) && preg_match('#valid_date#i', $aElement['rules']) && isSet($aElement['value'])) {
                     $oDate = new DateTime($aElement['value']);
                     $sDateFormat = preg_replace('#.*valid_date\[(.*)]#i', '$1', $aElement['rules']);
                     $sRet  = '<span class="value" >' . $oDate->format($sDateFormat) . '</span>';
                 } else {
                     $sRet = '<span class="value" >' . (isSet($aElement['value']) ? $aElement['value'] : 'Null') . '</span>';
                 }
                 break;
             case 'select':
                $sRet = '<span class="value" >';
                if ( !empty($aElement['selected'])) {
                    if ( is_array($aElement['selected']) ) {
                        $sRet .= implode(', ', $aElement['selected']);
                    } else {
                        $sRet .= $aElement['options'][$aElement['selected']];
                    }
                } else {
                    $sRet .= 'Null';
                }
                $sRet .= '</span>';
                break;

            case 'checkbox':
                $sRet = '<span class="value" >';
                if(isset($aElement['value'])) {
                
                    if($aElement['checked'] == 1) {
                    
                        $sRet .= 'Yes';
                    } elseif ($aElement['checked'] == 0) {
                    
                        $sRet .= 'No';
                    }
                }
                $sRet .= '</span>';
                break;

            default:
                $sRet = '<span class="value" >' . (isSet($aElement['value']) ? $aElement['value'] : 'Null') . '</span>';
                break;
         }
         return $sRet;
    }
}