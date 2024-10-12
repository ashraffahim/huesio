<?php

namespace app\controllers;

use app\components\Util;
use app\models\databaseObjects\Slot;
use app\controllers\_MainController;
use app\models\databaseObjects\Turf;
use app\models\exceptions\common\CannotSaveException;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * SlotsController implements the CRUD actions for Slot model.
 */
class SlotsController extends _MainController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Slot models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = Turf::findAll(['account_id' => Yii::$app->user->identity->account_id]);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Slot model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($nid)
    {
        $turf = Turf::findOne([
            'account_id' => Yii::$app->user->identity->account_id,
            'nid' => $nid
        ]);

        if (is_null($turf)) throw new NotFoundHttpException('The requested page does not exist.');

        $model = Slot::findAll(['turf_id' => $turf->id]);

        if ($this->request->isPost && Util::isFetchRequest()) {
            $slots = json_decode($this->request->post('slots'));

            $errors = $this->validateSlots($slots);

            if (count($errors) > 0) {
                $this->response->statusCode = 409;
                return $this->asJson(['collisions' => $errors]);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $mappedNid = [];

                // Nids from db
                foreach ($model as $slot) {
                    $mappedNid[$slot->nid][0] = $slot;
                }

                // Nids from front
                $newSlotsToAdd = [];
                foreach ($slots as $day) {
                    foreach ($day as $slot) {
                        if (isset($slot->backId) && array_key_exists($slot->backId, $mappedNid)) {
                            $mappedNid[$slot->backId][1] = $slot;
                        } else {
                            $newSlotsToAdd[] = $slot;
                        }
                    }
                }
                
                // Saving slots
                foreach ($mappedNid as $slotProduct) {
                    if (!array_key_exists(1, $slotProduct)) {
                        $slotProduct[0]->delete();
                        continue;
                    }

                    $slotProduct[0]->day = $slotProduct[1]->day;
                    $slotProduct[0]->start_time = $slotProduct[1]->from;
                    $slotProduct[0]->end_time = $slotProduct[1]->to;
                    $slotProduct[0]->is_open = $slotProduct[1]->isOpen;

                    if (!$slotProduct[0]->save()) throw new CannotSaveException($slotProduct[0]);
                }

                $mappingForFront = [];
                foreach ($newSlotsToAdd as $slot) {
                    $newSlot = new Slot();
                    $newSlot->nid = Util::nanoid(Slot::class);
                    $newSlot->turf_id = $turf->id;
                    $newSlot->day = $slot->day;
                    $newSlot->start_time = $slot->from;
                    $newSlot->end_time = $slot->to;
                    $newSlot->is_open = $slot->isOpen;

                    if (!$newSlot->save()) throw new CannotSaveException($newSlot);

                    $mappingForFront[$slot->tempId] = $newSlot->nid;
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }

            return $this->asJson($mappingForFront);
        }

        return $this->render('update', [
            'turf' => $turf,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Slot model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($nid)
    {
        $this->findModel($nid)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Slot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Slot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($nid)
    {
        $model = Slot::findOne(['nid' => $nid]);

        if (!is_null($model) && $model->turf->account_id === Yii::$app->user->identity->account_id) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /** Returns array of error */
    private function validateSlots(array $slots): array
    {
        $errors = [];

        foreach ($slots as $day) {
            foreach ($day as $slot) {
                foreach ($day as $slot2) {
                    if (($slot->from > $slot2->from) && ($slot->from < $slot2->to)) {
                        $errors[] = $slot->tempId;
                        $errors[] = $slot2->tempId;
                    }
                }
            }
        }

        return $errors;
    }
}
