<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class BlogForm extends Model
{
    public $handle;
    public $title;
    public $description;
    public $keywords;
    public $issue;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'description', 'keywords', 'handle'], 'required'],
            [['title', 'description', 'keywords', 'handle'], 'string', 'max' => 100],
            ['issue', 'string'],
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
