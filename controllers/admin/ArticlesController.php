<?php

namespace app\controllers\admin;

use app\components\StorageManager;
use app\components\Util;
use Yii;
use app\models\databaseObjects\Article;
use app\models\File;
use app\models\exceptions\common\CannotSaveException;
use app\models\forms\ArticleForm;
use InvalidArgumentException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ArticlesController extends _MainController {
    public function beforeAction($action)
    {
        Yii::$app->response->headers->add('X-Robots-Tag', 'noindex');
        $this->layout = 'admin';
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->redirect('/admin/articles/list');
    }

    public function actionList()
    {
        $articles = Article::find();
        $articlesCount = $articles->count();
        $page = Yii::$app->request->get('page', 0);
        $articles->limit(10)->offset($page);

        return $this->render('list', [
            'articles' => $articles->all(),
            'articlesCount' => $articlesCount,
            'page' => $page,
        ]);
    }

    public function actionCreate()
    {
        $article = new Article();
        $article->uuid = Util::generateUuid(Article::class);

        $model = new ArticleForm();

        $this->updateArticle($model, $article);

        return $this->render('create', ['model' => $model]);
    }

    public function actionEdit($uuid)
    {
        $article = Article::findOne(['uuid' => $uuid]);

        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        $model = new ArticleForm();

        $article->updation_date = date('Y-m-d h:i:s');
        $this->updateArticle($model, $article);

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Create or edit article
     * @param ArticleForm $model
     * @param Article $article
     */
    public function updateArticle(ArticleForm $model, Article $article)
    {
        $model->handle = $article->handle;
        $model->title = $article->title;
        $model->issue = \app\models\Issue::ISSUE_ID_TO_NAME[$article->issue_id] ?? 1;
        $model->description = $article->description;
        $model->keywords = $article->keywords;
        $model->image = !is_null($article->image_id) ? $article->file->uuid : null;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            $image = File::findOne(['uuid' => $model->image]);

            if (!is_null($image)) {
                $article->image_id = $image->id;
            }
            
            if($model->validate()) {
                        
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $article->handle = $model->handle;
                    $article->title = $model->title;
                    $article->description = $model->description;
                    $article->keywords = $model->keywords;
                    $article->creation_date = date('Y-m-d h:i:s');
                    $article->user_id = Yii::$app->user->identity->id;

                    if (!$article->save()) {
                        throw new CannotSaveException($article);
                    }

                    $transaction->commit();
                } catch(\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }

                return $this->redirect('/admin/articles/write/' . $article->uuid);

            }
        }

    }

    public function actionWrite($uuid) {
        $errors = [];
        $article = Article::findOne(['uuid' => $uuid]);
        
        if (is_null($article)) {
            throw new NotFoundHttpException();
        }

        if (Yii::$app->request->isPost) {
            try {
                $content = Yii::$app->request->post('content');
    
                if (is_null($content)) throw new InvalidArgumentException('Article content cannot be empty');
    
                StorageManager::uploadArticleContent(Yii::$app->request->post('content'), $uuid);
            } catch(\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        return $this->render('write', [
            'article' => $article,
            'errors' => $errors
        ]);
    }

    public function actionFiles()
    {
        $uploadedFiles = UploadedFile::getInstancesByName('file');
        $errors = [];
        
        if (Yii::$app->request->isPost) {
            foreach ($uploadedFiles as $uploadedFile) {
                if (mb_strlen($uploadedFile->baseName) > 96) {
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