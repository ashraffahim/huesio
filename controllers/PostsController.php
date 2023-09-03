<?php

namespace app\controllers;

use Yii;
use app\models\databaseObjects\Post;

class PostsController extends _MainController {
    public function beforeAction($action)
    {
        $this->layout = 'admin';
        return parent::beforeAction($action);
    }
    
    public function actionIndex()
    {
        return $this->redirect('/posts/list');
    }

    public function actionList()
    {
        $posts = Post::find();
        $postsCount = $posts->count();
        $page = Yii::$app->request->get('page', 0);
        $posts->limit(10)->offset($page);

        return $this->render('list', [
            'posts' => $posts->all(),
            'postsCount' => $postsCount,
            'page' => $page,
        ]);
    }

    public function actionCreate()
    {
        return $this->render('create');
    }
}

?>