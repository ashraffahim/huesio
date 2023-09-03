<?php

namespace app\models\databaseObjects;

/**
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string $password
 * @property string $auth_key
 */

class User extends \yii\db\ActiveRecord {

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 64],
            ['email', 'email'],
            ['auth_key', 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth key',
        ];
    }
}

?>