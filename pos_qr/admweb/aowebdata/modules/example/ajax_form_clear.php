<?php
$formData = $_POST;
function clearInSession($data, $parentKey = '')
{
    foreach ($data as $key => $value) {
        $sessionKey = $parentKey ? $parentKey . '[' . $key . ']' : $key;
        if (is_array($value)) {
            clearInSession($value, $sessionKey);
        } else {
            unset($_SESSION[$sessionKey]);
        }
    }
}
clearInSession($formData);
