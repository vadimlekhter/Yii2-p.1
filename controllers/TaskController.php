<?php

namespace app\controllers;

use app\models\TaskUser;
use Yii;
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{

    public $defaultAction = 'my';

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
     * Lists all Task models created by login user.
     * @return mixed
     */
    public function actionMy()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()->byCreator(Yii::$app->user->id),
        ]);

        return $this->render('my', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Task models created by login user and shared with other users.
     * @return mixed
     */
    public function actionShared()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()
                ->innerJoinWith(Task::RELATION_TASK_USERS)
                ->byCreator(Yii::$app->user->id)
        ]);

        return $this->render('shared', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Task models created by other user and accessed by login user.
     * @return mixed
     */
    public function actionAccessed()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()
                ->innerJoinWith(Task::RELATION_TASK_USERS)
                ->where(['user_id' => \Yii::$app->user->id])
        ]);

        return $this->render('accessed', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if not this or shared user task exception
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
//        $isSharedUser = TaskUser::find()
//            ->select('user_id')
//            ->where(['task_id'=>$id])
//            ->andWhere(['user_id'=>\Yii::$app->user->id])
//            ->exists();

        $isSharedUser = $model
            ->getTaskUsers()
            ->select(['task_id'=>'id'])
            ->where(['user_id'=>\Yii::$app->user->id])->exists();

        if ($model->creator_id !== \Yii::$app->user->id && !$isSharedUser) {
            throw new ForbiddenHttpException();
        }

        $dataProvider = null;

        if ($model->creator_id == \Yii::$app->user->id) {
            $dataProvider = new ActiveDataProvider([
                'query' => TaskUser::find()->with(TaskUser::RELATION_USER)
                    ->where(['task_user.task_id' => $id])->select('*')

            ]);
        }

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'my' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'New task created');
            return $this->redirect(['my']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'my' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if not this user task exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->creator_id !== \Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Task updated');
            return $this->redirect(['my']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if not this user task exception
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->creator_id !== \Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Task deleted');
        return $this->redirect(['my']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
