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

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'description', 'keywords'], 'required'],
            [['title', 'description', 'keywords'], 'string', 'max' => 100],
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

}
