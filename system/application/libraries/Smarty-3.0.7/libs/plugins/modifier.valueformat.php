<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifier
 */

function smarty_modifier_valueFormat($mValue = NULL) {
    if ($mValue === '0' || $mValue === 0) {
        return _("No");
    } elseif ($mValue === false || !isset($mValue) || empty($mValue)) {
        return _("Null");
    } elseif ($mValue == 1) {
        return _("Yes");
    } else {
        return _($mValue);
    }

    return null;
}

?>
