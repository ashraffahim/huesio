<?php

namespace app\components;

use app\models\exceptions\common\CannotGenerateUuidException;
use DateTime;
use Ramsey\Uuid\Uuid;
use Yii;

class Util {

    public const USER_DATE_FORMAT_LONG = 'd M, Y';

    public static function getAppName() {
        return Yii::$app->params['name'];
    }

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

    public static function getUserFormattedDate(string $date, $type = self::USER_DATE_FORMAT_LONG)
    {
        return (new DateTime($date))->format($type);
    }

}

?>