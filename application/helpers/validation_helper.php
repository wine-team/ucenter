<?php
/*
 * 日期验证 YYYY-MM-DD
 */
function checkDateFormat($date) {
    // match the format of the date
    if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) {
        // check whether the date is valid of not
        if (checkdate($parts[2], $parts[3], $parts[1])) {
             return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/*
 * $allContent : 1,2,4,8使用逗号分割
* $findme     : 4
* 验证$findme是否存在与$allContent内。
*/
function validateFind($findme = '', $allContent)
{
    $result = false;
    if (empty($findme)) {
        return $result;
    }
    
    if (strpos($allContent, ',') > 0) {
        $allContent = explode(',', $allContent);
    }
    if ((is_array($allContent) && in_array($findme, $allContent)) || ($findme == $allContent)) {
        $result = true;
    }

    return $result;
}

/**
 * 邮政编码
 */
function validateZipCode($code)
{
    return (preg_match('/^[0-9]{6}$/', $code)) ? TRUE : FALSE;
}

/**
 * 验证银行卡号
 */
function validateBankCard($card)
{
    return (preg_match('/^[0-9]{16,19}$/', $card)) ? TRUE : FALSE;
}

/**
 * 验证手机号码
 */
function validateMobilePhone($mobile)
{
    return (preg_match('/^1[34578]\d{9}$/', $mobile)) ? TRUE : FALSE;
}

/**
 * 验证中文名称姓名
 */
function validateChineseName($name)
{
    return (preg_match('/^[\x{4e00}-\x{9fa5}]{2,30}+$/u', $name)) ? TRUE : FALSE;
}

/**
 * 验证有效2位小数点
 */
function validateFloatNumber($number)
{
    return preg_match('/^\d+(\.\d{1,2})?$/', $number) ? TRUE : FALSE;
}

/**
 * 验证身份证是否有效
 * @param unknown $sfz
 * @return boolean
 */
function validateSfz($sfz)
{
    $len = strlen(trim($sfz));
    if ($len == 32 || $len == 6) {
        return TRUE;
    }
    if ($len > 36 ) {
        $arrSfz = explode(',', $sfz);
        foreach ($arrSfz as $value) {
            if (!checkSfz($value)) {
                return FALSE;
            }
        }
    } else {
        if (!checkSfz($sfz)) return FALSE;
    }
    return TRUE;
}

/**
 * 验证身份证
 */
function checkSfz($sfz)
{
    if (strlen($sfz) != 18) {
        return false;
    }
    $key = '10X98765432';
    $rs = 0;
    for ($i = 0,$j = 18; $i < 17; $i++, $j--) {
        $rs = $rs + $sfz[$i] * (pow(2, $j - 1) % 11);
    }
    return $key[$rs % 11] == substr($sfz, -1, 1);
}

