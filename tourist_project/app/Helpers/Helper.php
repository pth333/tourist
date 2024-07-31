<?php

use App\Models\Setting;
function getConfigValueSettingTable($configKey){
    $config_key = Setting::where('config_key', $configKey)->first();
    if(!empty($config_key)){
        return $config_key->config_value;
    }
    return null;
}
