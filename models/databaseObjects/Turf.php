<?php

namespace app\models\databaseObjects;

use Yii;

/**
 * This is the model class for table "turf".
 *
 * @property int $id
 * @property string $nid
 * @property string|null $name
 * @property string $address
 */
class Turf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'turf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nid', 'address'], 'required'],
            [['nid'], 'string', 'max' => 21],
            [['name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 100],
            [['nid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nid' => 'Nid',
            'name' => 'Name',
            'address' => 'Address',
        ];
    }
}
