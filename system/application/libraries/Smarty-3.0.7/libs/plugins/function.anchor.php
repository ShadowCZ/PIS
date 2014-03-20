<?php
function smarty_function_anchor($params,$Smarty) {
    if (! isset($params['id'])) $params['id'] = null;
    return anchor($params['uri'], $params['label'], null, $params['id']);
}