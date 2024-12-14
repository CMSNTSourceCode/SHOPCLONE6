<?php

if (!defined('IN_SITE')) {
    die('The Request Not Found');
}

// chọn ngôn ngữ
function setLanguage($id)
{
    global $CMSNT;
    if ($row = $CMSNT->get_row("SELECT * FROM `languages` WHERE `id` = '$id' AND `status` = 1 ")) {
        $isSet = setcookie('language', $row['lang'], time() + (31536000 * 30), "/"); // 31536000 = 365 ngày
        if ($isSet) {
            return true;
        } else {
            return false;
        }
    }
    return false;
}

// lấy ngôn ngữ mặc định
function getLanguage()
{
    global $CMSNT;
    if (isset($_COOKIE['language'])) {
        $language = check_string($_COOKIE['language']);
        $rowLang = $CMSNT->get_row("SELECT * FROM `languages` WHERE `lang` = '$language' AND `status` = 1 ");
        if ($rowLang) {
            return $rowLang['lang'];
        }
    }
    $rowLang = $CMSNT->get_row("SELECT * FROM `languages` WHERE `lang_default` = 1 ");
    if ($rowLang) {
        return $rowLang['lang'];
    }
    return false;
}
//hiển thị ngôn ngữ
function __($name)
{
    global $CMSNT;
    if (isset($_COOKIE['language'])) {
        $language = check_string($_COOKIE['language']);
        $rowLang = $CMSNT->get_row("SELECT * FROM `languages` WHERE `lang` = '$language' AND `status` = 1 ");
        if ($rowLang) {
            $rowTran = $CMSNT->get_row("SELECT * FROM `translate` WHERE `lang_id` = '".$rowLang['id']."' AND `name` = '$name' ");
            if ($rowTran) {
                return $rowTran['value'];
            }
        }
    }
    $rowLang = $CMSNT->get_row("SELECT * FROM `languages` WHERE `lang_default` = 1 ");
    if ($rowLang) {
        $rowTran = $CMSNT->get_row("SELECT * FROM `translate` WHERE `lang_id` = '".$rowLang['id']."' AND `name` = '$name' ");
        if ($rowTran) {
            return $rowTran['value'];
        }
    }
    return $name;
}

