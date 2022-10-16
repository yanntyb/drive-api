<?php

namespace App\Services;

class ConfigService
{
    public static function getConfigValues(string $configFile)
    {
        return app("config")->get($configFile);
    }

    public static function getConfigSpecificValue(string $configFile, string $key)
    {
        $config = self::getConfigValues($configFile);
        if(isset($config[$key])){
            return $config[$key];
        }
        return null;
    }
}
