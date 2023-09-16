<?php

namespace app\controllers;

use app\models\databaseObjects\Blog;
use yii\web\NotFoundHttpException;

class BlogsController extends _MainController {    
    public function actionHealth() {
        $blogs = Blog::find()->orderBy(['id' => SORT_DESC])->limit(10)->all();

        return $this->render('home', [
            'blogs' => $blogs
        ]);
    }

    public function actionRead($handle)
    {
        $blog = Blog::findOne(['handle' => $handle]);

        if (is_null($blog)) {
            throw new NotFoundHttpException();
        }

        $this->layout = 'blog';
        return $this->render('read', [
            'blog' => $blog,
            'urlSuffix' => $handle,
        ]);
    }

}

?>