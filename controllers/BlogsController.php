<?php

namespace app\controllers;

use app\models\databaseObjects\Blog;
use yii\web\NotFoundHttpException;

class BlogsController extends _MainController {
    public function actionRead($uuid = null, $title = null)
    {
        if (is_null($uuid)) {
            throw new NotFoundHttpException();
        }

        $blog = Blog::findOne(['uuid' => $uuid]);

        if (is_null($blog)) {
            throw new NotFoundHttpException();
        }

        $formattedTitle = str_replace(' ', '-', strtolower($blog->title));

        if ($title !== $formattedTitle) {
            return $this->redirect('/health/' . $uuid . '/' . $formattedTitle);
        }

        $this->layout = 'blog';
        return $this->render('read', [
            'blog' => $blog,
            'urlSuffix' => $title,
        ]);
    }
}

?>