<?php

namespace app\controllers;

use app\models\databaseObjects\Blog;
use yii\web\NotFoundHttpException;

class BlogsController extends _MainController {
    public function actionRead($handle = null)
    {
        if (is_null($handle)) {
            throw new NotFoundHttpException();
        }

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