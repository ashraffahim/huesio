<?php

namespace app\models\databaseObjects;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $nid
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password_hash
 * @property int|null $account_id
 * @property int|null $email_verified
 *
 * @property Account[] $accounts
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nid', 'first_name', 'last_name', 'email', 'password_hash'], 'required'],
            [['account_id', 'email_verified'], 'default', 'value' => null],
            [['account_id', 'email_verified'], 'integer'],
            [['nid'], 'string', 'max' => 21],
            [['first_name', 'last_name'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 64],
            [['password_hash'], 'string', 'max' => 128],
            [['email'], 'unique'],
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'account_id' => 'Account ID',
            'email_verified' => 'Email Verified',
        ];
    }

    /**
     * Gets query for [[Accounts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::class, ['owner_user_id' => 'id']);
    }
}
