<?php

namespace app\components;

use app\models\exceptions\common\CannotGenerateUuidException;
use Ramsey\Uuid\Uuid;

class Util {
    public static function generateUuid(string $model = null, string $field = 'uuid', int $maxIterations = 3) : string
    {
        $iterations = 0;
        do {
            $uuid = (string) Uuid::uuid4()->getHex();
    
            if (is_null($model)) {
                return $uuid;
            }
    
            $existingModel = $model::findOne([$field => $uuid]);
    
            if (is_null($existingModel)) {
                return $uuid;
            }
        } while($iterations < $maxIterations);

        throw new CannotGenerateUuidException();
    }
}

?>