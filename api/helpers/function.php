<?php

function getTranslate($translate)
{
    return Yii::t('main', $translate) !== "" ? Yii::t('main', $translate) : $translate;
}

function t($translate)
{
    return getTranslate($translate);
}

function addDaysExcludingWeekends($date, $daysToAdd) {
    $resultDate = new DateTime($date);

    $daysAdded = 0;
    while ($daysAdded < $daysToAdd) {
        $resultDate->modify('+1 day');

        // If the day is not a weekend (Saturday = 6, Sunday = 0), increase the count
        if ($resultDate->format('N') < 6) {
            $daysAdded++;
        }
    }

    return $resultDate->format('Y-m-d H:i:s');
}
function dd()
{
    $args = func_get_args();
    if (count($args) == 0) {
        exit();
    }
    echo "<pre>";
    foreach ($args as $arg) {
        print_r($arg);
    }
    exit();
}


function checkPkcs($pkcs7){
    $auth_url="http://127.0.0.1:8080/backend/auth";


    $user_ip = empty($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_REAL_IP'];
    $host = $_SERVER['HTTP_HOST'];

    $headers = array('Host: '.$host, 'X-Real-IP: '.$user_ip);

    //$pkcs7 = $_POST['pkcs7'];
    //$keyId = $_POST['keyId'];

    $ch = curl_init();
    $postvars = $pkcs7;
    $url = $auth_url;
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
    curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
    curl_setopt($ch,CURLOPT_TIMEOUT, 20);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close ($ch);
    return $response;

}
function checkPkcs2($pkcs7)
{

    $xmlcontent = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/"><Body><verifyPkcs7 xmlns="http://v1.pkcs7.plugin.server.dsv.eimzo.yt.uz/"><pkcs7B64 xmlns="">' . $pkcs7 . '</pkcs7B64></verifyPkcs7></Body></Envelope>';

    $arr = array('Content-Type: text/xml; charset="UTF-8"', 'X-Real-IP:1.2.3.4', 'Host:dxp.uz', 'X-Real-Host:dxp.uz');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8080/backend/auth");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlcontent);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);

        return [
            'status' => 'error',
            'message' => $error_msg
        ];
    }

    $response = str_replace([
        '<?xml version="1.0" ?><S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/"><S:Body><ns2:verifyPkcs7Response xmlns:ns2="http://v1.pkcs7.plugin.server.dsv.eimzo.yt.uz/"><return>',
        '</return></ns2:verifyPkcs7Response></S:Body></S:Envelope>'
    ], '', $response);

    return $response;
}

function checkPkcsPing()
{

    $arr = array('Content-Type: text/xml; charset="UTF-8"', 'X-Real-IP:1.2.3.4', 'Host:dxp.uz', 'X-Real-Host:dxp.uz');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8080/ping");
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);

        return [
            'status' => 'error',
            'message' => $error_msg
        ];
    }

    return $response;
}
function toRoute($route, $scheme = false)
{
    return \yii\helpers\Url::toRoute($route);
}

function isDate($value)
{
    if (!$value) {
        return false;
    }

    try {
        new \DateTime($value);
        return true;
    } catch (\Exception $e) {
        return false;
    }
}