<?php

namespace Database\Factories\Helpers;




class FactoryHelper
{
    /**
     * This function will get a random model id from the DB
     * @param string | HasFactory $model
     */
    public static function getRandomModelId(string $model)
    {
        // Get model count
        $count = $model::query()->count();

        if($count === 0){
            // create a new record and retrieve the record id
            return $model::factory()->create()->id;
        }else {
            return rand(1,$count);
        }
    }
}
