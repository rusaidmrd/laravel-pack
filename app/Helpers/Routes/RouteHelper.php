<?php

namespace App\Helpers\Routes;

class RouteHelper {
    public static function includeRouteFiles(string $folder) {
        // Iterate thru the v1 folder recursively
        $dirIterator = new \RecursiveDirectoryIterator($folder);

        /**
         * @var \RecursiveDirectoryIterator | \RecursiveIteratorIterator
         */
        $iterator = new \RecursiveIteratorIterator($dirIterator);

        // Require the file in iteration
        while($iterator->valid())
        {
            if(!$iterator->isDot()
                && $iterator->isFile()
                && $iterator->isReadable()
                && $iterator->current()->getExtension() === "php"
            )
            {
                require $iterator->key();
                //require $iterator->current()->getPathname();
            }
            $iterator->next();
        }
    }
}
