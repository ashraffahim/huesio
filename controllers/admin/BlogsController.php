<?php

namespace app\controllers\admin;

use app\components\StorageManager;
use app\components\Util;
use Yii;
use app\models\databaseObjects\Blog;
use app\models\exceptions\common\CannotSaveException;
use app\models\forms\BlogForm;
use InvalidArgumentException;
use yii\web\NotFoundHttpException;

class BlogsController extends _MainController {
    public function beforeAction($action)
    {
        $this->layout = 'admin';
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->redirect('/admin/blogs/list');
    }

    public function actionList()
    {
        $blogs = Blog::find();
        $blogsCount = $blogs->count();
        $page = Yii::$app->request->get('page', 0);
        $blogs->limit(10)->offset($page);

        return $this->render('list', [
            'blogs' => $blogs->all(),
            'blogsCount' => $blogsCount,
            'page' => $page,
        ]);
    }

    public function actionCreate()
    {
        $model = new BlogForm();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            
            if($model->validate()) {
                
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $blog = new Blog();
                    $blog->uuid = Util::generateUuid(Blog::class);
                    $blog->title = $model->title;
                    $blog->description = $model->description;
                    $blog->keywords = $model->keywords;
                    $blog->creation_date = date('Y-m-d h:i:s');
                    $blog->user_id = Yii::$app->user->identity->id;
    
                    if (!$blog->save()) {
                        throw new CannotSaveException($blog);
                    }

                    $transaction->commit();
                } catch(\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }

                return $this->redirect('/blogs/write/' . $blog->uuid);

            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionWrite($uuid) {
        $errors = [];
        $blog = Blog::findOne(['uuid' => $uuid]);
        
        if (is_null($blog)) {
            throw new NotFoundHttpException();
        }

        if (Yii::$app->request->isPost) {
            try {
                $content = Yii::$app->request->post('content');
    
                if (is_null($content)) throw new InvalidArgumentException('Blog content cannot be empty');
    
                StorageManager::uploadBlogContent(Yii::$app->request->post('content'), $uuid);
            } catch(\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        return $this->render('write', [
            'blog' => $blog,
            'errors' => $errors
        ]);
    }
}

?>