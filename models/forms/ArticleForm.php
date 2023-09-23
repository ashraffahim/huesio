<?php

namespace app\models\forms;

use yii\base\Model;

/**
 * ArticleForm is the model behind the article form.
 *
 * @property-read User|null $user
 *
 */
class ArticleForm extends Model
{
    public $handle;
    public $title;
    public $description;
    public $keywords;
    public $issue;
    public $image;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'description', 'keywords', 'handle'], 'required'],
            [['title', 'keywords', 'handle'], 'string', 'max' => 100],
            ['description', 'string', 'max' => 255],
            [['issue', 'image'], 'string'],
            ['issue', 'validateIssue'],
            ['handle', 'validateHandle'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'handle' => 'Handle',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'image' => 'Image UUID',
        ];
    }

    public function validateIssue($attribute, $params, $validator)
    {
        if (!in_array($this->$attribute, array_values(\app\models\Issue::ISSUE_ID_TO_NAME))) {
            $this->addError($attribute, 'Invalid issue');
        }
    }

    public function validateHandle($attribute, $params, $validator)
    {
        if (!preg_match('/^[a-z0-9-]+$/', $this->$attribute)) {
            $this->addError($attribute, 'Handle must only contain a-z 0-9 \"-\" lowercase and no spaces');
        }
    }

}
