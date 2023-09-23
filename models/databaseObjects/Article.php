<?php

namespace app\models\databaseObjects;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $handle
 * @property string|null $title
 * @property string|null $issue_id
 * @property string|null $description
 * @property string|null $keywords
 * @property int $image_id
 * @property string $user_id
 * @property bool $is_published
 * @property string|null $creation_date
 * @property string|null $updation_date
 * @property string|null $publish_date
 * 
 * @property User[] $user
 * @property File $file
 * 
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'user_id', 'title', 'handle'], 'required'],
            ['uuid', 'unique'],
            ['handle', 'unique'],
            ['uuid', 'string', 'max' => 32],
            ['is_published', 'boolean'],
            [['keywords', 'title', 'handle'], 'string', 'max' => 100],
            ['description', 'string', 'max' => 255],
            [['creation_date', 'updation_date', 'publish_date'], 'safe'],
            [['user_id', 'issue_id', 'image_id'], 'integer'],
            ['user_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            ['issue_id', 'exist', 'skipOnError' => true, 'targetClass' => Issue::class, 'targetAttribute' => ['issue_id' => 'id']],
            ['image_id', 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['image_id' => 'id']],
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
            'handle' => 'Handle',
            'title' => 'Title',
            'issue_id' => 'Issue ID',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'image_id' => 'File Id',
            'user_id' => 'User Id',
            'creation_date' => 'Creation Date',
            'updation_date' => 'Updation Date',
        ];
    }
    
    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'id']);
    }
    
    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'image_id']);
    }
}
