<?php

class Config{

     public static function DB_HOST(){
        return Config::get_env("DB_HOST", "");
      }

    public static function DB_USERNAME(){
        return Config::get_env("DB_USERNAME", "");
    }
    
    public static function DB_PASSWORD(){
        return Config::get_env("DB_PASSWORD", "");
    }
    
      public static function DB_SCHEMA(){
        return Config::get_env("DB_SCHEMA", "");
    } 

    public static function DB_PORT(){
        return Config::get_env("DB_PORT", "");
    }

    public static function PYTHON_PATH(){
        return Config::get_env("PYTHON_PATH", "");
    }

    public static function ANALYSE_COMMAND(){
        return Config::get_env("ANALYSE_COMMAND", "");
    }

    public static function JWT_SECRET(){
        return Config::get_env("JWT_SECRET", "");
    }

    public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
       }
      
}

?> 