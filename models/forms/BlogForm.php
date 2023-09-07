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
            [['title', 'description', 'keywords'], 'required'],
            [['title', 'description', 'keywords'], 'string', 'max' => 100],
            ['issue', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
        ];
    }

    public function validateIssue($model, $attribute)
    {
        if (!in_array($model->$attribute, array_keys(\app\models\Issue::ISSUE_ID_TO_NAME))) {
            $this->addError($attribute, 'Invalid issue');
        }
    }

}
