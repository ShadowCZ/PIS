<?php

function smarty_block_form($params, $str, $template, $repeat) {
    $CI =& get_instance();
    $sAction = $CI->iform->sAction;    
    $sEnctype = $CI->iform->sEnctype;
    
    if ( !empty($sEnctype) ) {
        $sEnctype = ' enctype="' . $sEnctype . '"';
    }
    
    return '<form action="' . base_url() . 'index.php/' . $sAction . '" method="POST"' . $sEnctype . '>' . $str . '</form>';
}