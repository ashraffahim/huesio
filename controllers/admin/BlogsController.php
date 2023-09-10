<?php

namespace app\controllers\admin;

use app\components\StorageManager;
use app\components\Util;
use Yii;
use app\models\databaseObjects\Blog;
use app\models\File;
use app\models\exceptions\common\CannotSaveException;
use app\models\forms\BlogForm;
use InvalidArgumentException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
        $blog = new Blog();
        $blog->uuid = Util::generateUuid(Blog::class);

        $model = new BlogForm();

        $this->updateBlog($model, $blog);

        return $this->render('create', ['model' => $model]);
    }

    public function actionEdit($uuid)
    {
        $blog = Blog::findOne(['uuid' => $uuid]);

        if (is_null($blog)) {
            throw new NotFoundHttpException();
        }

        $model = new BlogForm();

        $blog->updation_date = date('Y-m-d h:i:s');
        $this->updateBlog($model, $blog);

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Create or edit blog
     * @param BlogForm $model
     * @param Blog $blog
     */
    public function updateBlog(BlogForm $model, Blog $blog)
    {
        $model->handle = $blog->handle;
        $model->title = $blog->title;
        $model->issue = \app\models\Issue::ISSUE_ID_TO_NAME[$blog->issue_id] ?? 1;
        $model->description = $blog->description;
        $model->keywords = $blog->keywords;
        $model->image = !is_null($blog->image_id) ? $blog->file->uuid : null;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            $image = File::findOne(['uuid' => $model->image]);

            if (!is_null($image)) {
                $blog->image_id = $image->id;
            }
            
            if($model->validate()) {
                        
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $blog->handle = $model->handle;
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

                return $this->redirect('/admin/blogs/write/' . $blog->uuid);

            }
        }

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

    public function actionFiles()
    {
        $uploadedFiles = UploadedFile::getInstancesByName('file');
        $errors = [];
        
        if (Yii::$app->request->isPost) {
            foreach ($uploadedFiles as $uploadedFile) {
                if (mb_strlen($uploadedFile->baseName) > 30) {
                    $errors[] = 'Name cannot be more than 30 characters';
                    break;
                }
                
                if (!in_array($uploadedFile->extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
                    $errors[] = 'Invalid file type';
                }
            }
            
            if (!count($errors) > 0) {
                /** @var File[] $filesToRollback */
                $filesToRollback = [];

                $transaction = Yii::$app->db->beginTransaction();
                try {
                   
                    foreach ($uploadedFiles as $uploadedFile) {
                        $file = new File();
                        $file->uuid = Util::generateUuid(File::class);
                        $file->name = $uploadedFile->baseName . '.' . $uploadedFile->extension;

                        if (!$file->save()) {
                            throw new CannotSaveException($file);
                        }

                        $file->uploadMedia($uploadedFile->tempName, $uploadedFile->extension);

                        $filesToRollback[] = $file;
                    }

                    $transaction->commit();
                } catch (\Exception $e) {
                    $transaction->rollBack();

                    foreach ($filesToRollback as $fileToRollback) {
                        $fileToRollback->unlinkMedia();
                    }

                    throw $e;
                }
            }
        }

        $files = File::find();
        $page = Yii::$app->request->get('page', 0);
        $filesCount = $files->count();
        $files->limit(10)->offset($page)->orderBy(['id' => SORT_DESC]);

        return $this->render('files', [
            'files' => $files->all(),
            'filesCount' => $filesCount,
            'page' => $page,
            'errors' => $errors,
        ]);
    }
}

?>