<?php
$formData = $_POST;
function saveInSession($data, $parentKey = '')
{
    foreach ($data as $key => $value) {
        $sessionKey = $parentKey ? $parentKey . '[' . $key . ']' : $key;
        if (is_array($value)) {
            saveInSession($value, $sessionKey);
        } else {
            $_SESSION[$sessionKey] = $value;
        }
    }
}
saveInSession($formData);
pre($_SESSION);
