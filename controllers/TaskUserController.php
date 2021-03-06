<?php

namespace app\controllers;

use app\models\Task;
use app\models\User;
use Yii;
use app\models\TaskUser;
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

        $yetSharedUsers = TaskUser::find()->where(['task_id'=>$taskId])->select('user_id')->asArray()->column();

        $model = new TaskUser();

        $model->task_id = $taskId;



        $users = User::find()->where(['<>', 'id', \Yii::$app->user->id])->andWhere(['not in', 'id', $yetSharedUsers])
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
     * @throws ForbiddenHttpException if the user is not creator of the task
     */

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $task_id = $model->task_id;

        $creator_id = $model->task->creator_id;

        if (\Yii::$app->user->id !== $creator_id) {
            throw new ForbiddenHttpException('You are not creator of the task!');
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'User unlinked');
        
        return $this->redirect(['task/view', 'id' => $task_id]);
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
