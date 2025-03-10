<?php

function general_escape_js($string)
{
    trigger_error('general_escape_js() has been deprecated. Instead use functions::escape_js()', E_USER_DEPRECATED);
    return functions::escape_js($string);
}

function general_path_friendly($string, $language_code = null)
{
    trigger_error('general_path_friendly() has been deprecated. Instead use functions::format_path_friendly()', E_USER_DEPRECATED);
    return functions::format_path_friendly($string);
}

function general_order_public_checksum($order_id)
{
    trigger_error(__METHOD__ . '() is deprecated. Use reference::order(id)->public_key', E_USER_DEPRECATED);
    return reference::order($order_id)->public_key;
}
