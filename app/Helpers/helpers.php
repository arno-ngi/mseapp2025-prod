<?php

function flash($message = null)
{
    $flash = app('App\Helpers\Flash');

    if (func_num_args() == 0) {
        return $flash;
    }

    return $flash->info($message);
}

function getAppSetting($key)
{
    return \Illuminate\Support\Facades\Cache::remember('appsettings:' . $key, 10080, function () use ($key) {

        $setting = \App\Models\AppSetting::whereSettingKey($key)->first();

        if(is_null($setting))
        {
            return '-';
        }

        return $setting->setting_value;
    });
}
function getCategoryArray()
{
    return \Illuminate\Support\Facades\Cache::remember('categoriesarray', 10080, function () {
        return \App\Models\Category::pluck('name', 'id');;
    });
}

function getCurrencyArray()
{
    return array('EUR'=>'EUR', 'USD'=>'USD', 'GBP'=>'GBP', 'CZK'=>'CZK', 'YTL'=>'YTL');
}

function getStatusSafety()
{
    $statuses = [
        1 => 'YES',
        2 => 'NO',
        3 => '-',
    ];
    return $statuses;
}

function getStatusEnvironment()
{
    $statuses = [
        1 => 'RELEVANT',
        2 => 'IRRELEVANT',
        3 => '-',
    ];
    return $statuses;
}

function getInitialsAttribute($name, $firstname){
    $name = $firstname . ' ' . $name;
    $name_array = explode(' ',trim($name));

    $firstWord = $name_array[0];
    $lastWord = $name_array[count($name_array)-1];

    return $lastWord[0]."".$firstWord[0];
}

function getHttpChecks()
{
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];
    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    $useragent = $_SERVER['HTTP_USER_AGENT'];

    return array('ip' => $ip, 'useragent' => $useragent);
}

function getExtensionIcon($file)
{
    switch (strtolower(\File::extension($file))) {
        case "msg":
            return 'bx bx-mail-send';
            break;
        case "eml":
            return 'bx bx-mail-send';
            break;
        case "pdf":
            return 'bx bxs-file-pdf';
            break;
        case "doc":
            return 'bx bxs-file';
            break;
        case "docx":
            return 'bx bxs-file';
            break;
        default:
            return 'bx bx-file-blank';
    }
}
