<?php

namespace app\controllers;

use app\models\Task;
use app\models\User;
use Yii;
use app\models\TaskUser;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TaskUserController implements the CRUD actions for TaskUser model.
 */
class TaskUserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'unshare-all' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Creates a new TaskUser model.
     * If creation is successful, the browser will be redirected to the 'task/my' page.
     * @param integer taskId
     * @throws ForbiddenHttpException not this user task exception
     * @throws NotFoundHttpException not found task exception
     * @return mixed
     */
    public function actionCreate($taskId)
    {
        $model = Task::findOne($taskId);

        if ($model == null) {
            throw new NotFoundHttpException();
        }

        if ($model->creator_id !== \Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $model = new TaskUser();

        $model->task_id = $taskId;

        $users = User::find()->where(['<>', 'id', \Yii::$app->user->id])
            ->select('username')
            ->indexBy('id')
            ->column();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'New access to task created');
            return $this->redirect(['task/my', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'users' => $users,
        ]);
    }

    /**
     * Deletes an existing TaskUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Unshares a new TaskUser model.
     * If unsharing is successful, the browser will be redirected to the 'task/shared' page.
     * @param integer taskId
     * @throws ForbiddenHttpException not this user task exception
     * @throws NotFoundHttpException not found task exception
     * @return mixed
     */
    public function actionUnshareAll($taskId)
    {
        $model = Task::findOne($taskId);

        if ($model == null) {
            throw new NotFoundHttpException();
        }

        if ($model->creator_id !== \Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $model->unlinkAll(Task::RELATION_ACCESSED_USERS, true);
        Yii::$app->session->setFlash('success', 'Task unshared.');

        return $this->redirect(['task/shared']);
    }

    /**
     * Finds the TaskUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
