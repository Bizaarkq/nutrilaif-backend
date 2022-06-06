<?php

namespace App\Traits;

use Ulid\Ulid;

trait HasUlid
{
    public static function bootHasUlid(){
        static::creating(function ($model){
            if(!isset($model->id)){
                $model->id = (string) Ulid::generate(true);
            }
        });
    }

    public function initializeHasUlid(){
        $this->incrementing = false;
        $this->keyType = 'string';
    }


}
