<?php

namespace app\controllers;

use app\models\databaseObjects\Article;
use yii\web\NotFoundHttpException;

class ArticlesController extends _MainController {    
    public function actionHealth() {
        $articles = Article::find()->orderBy(['id' => SORT_DESC])->limit(10)->all();

        return $this->render('home', [
            'articles' => $articles
        ]);
    }

    public function actionRead($handle)
    {
        $article = Article::findOne(['handle' => $handle]);

        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        $this->layout = 'article';
        return $this->render('read', [
            'article' => $article,
            'urlSuffix' => $handle,
        ]);
    }

}

?>