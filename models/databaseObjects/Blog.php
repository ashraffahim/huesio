<?php

namespace app\models\databaseObjects;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $title
 * @property string|null $description
 * @property string|null $keywords
 * @property string $user_id
 * @property bool $is_published
 * @property string|null $creation_date
 * @property string|null $updation_date
 * @property string|null $publish_date
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'user_id', 'title'], 'required'],
            ['uuid', 'unique'],
            ['uuid', 'string', 'max' => 32],
            ['is_published', 'boolean'],
            [['description', 'keywords', 'title'], 'string', 'max' => 100],
            [['creation_date', 'updation_date', 'publish_date'], 'safe'],
            ['user_id', 'integer'],
            ['user_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'user_id' => 'User Id',
            'creation_date' => 'Creation Date',
            'updation_date' => 'Updation Date',
        ];
    }
}