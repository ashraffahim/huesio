<?php

namespace app\controllers;

use app\models\databaseObjects\Blog;
use yii\web\NotFoundHttpException;

class BlogsController extends _MainController {
    public function actionRead($title = null)
    {
        if (is_null($title)) {
            throw new NotFoundHttpException();
        }

        $blog = Blog::findOne(['title' => str_replace('-', ' ', $title)]);

        if (is_null($blog)) {
            throw new NotFoundHttpException();
        }

        $this->layout = 'blog';
        return $this->render('read', [
            'blog' => $blog,
            'urlSuffix' => $title,
        ]);
    }
}

?>