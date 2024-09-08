<?php

namespace App\Services\Factories;

use App\Contracts\NewsParamsInterface;
use App\Contracts\NewsSourceInterface;
use App\Services\Models\NewsParams;

class ParamsBuilderFactory
{
    public static function create(NewsSourceInterface $source, NewsParams $params)
    {
        $className = str_replace('Source','Params', class_basename($source));
        $class = 'App\\Services\\NewsParams\\' . $className;

        if ( class_exists($class) && in_array(NewsParamsInterface::class, class_implements($class)) )
            return (new $class($params))->applyParam();

        return [];
    }

}
