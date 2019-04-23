<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\Task;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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


    public function actionTest()
    {
        $user = new User;
        $user->delete();
//        $task = new Task();
//        $task=Task::findOne(8);
//        $task->title = 'Task7-2';
//        $task->description = 'Task7_Description';
//        $task->save();


//        $user = new User();
//
//        $user->username = 'Mary White';
//        $user->password_hash = '12345678';
//        $user->creator_id = 3;
//        $user->created_at = time();
//
//        $user->save();

//        $user = User::findOne(1);
//
//        $task = new Task();
//        $task->title = 'Task1';
//        $task->description = 'Task1_Description';
//        $task->created_at = time();
//        $task->link(Task::RELATION_CREATOR, $user);
//
//        $task = new Task();
//        $task->title = 'Task2';
//        $task->description = 'Task2_Description';
//        $task->created_at = time();
//        $task->link(Task::RELATION_CREATOR, $user);
//
//        $task = new Task();
//        $task->title = 'Task3';
//        $task->description = 'Task3_Description';
//        $task->created_at = time();
//        $task->link(Task::RELATION_CREATOR, $user);

//        $data = User::find()->with(User::RELATION_TASKS)->asArray()->all();

//        $task = Task::findOne(2);
//        $task->creator_id=2;
//        $task->save();
//        $task=Task::findOne(3);
//        $task->creator_id=3;
//        $task->save();
//


//        _end($task = Task::find()->with(Task::RELATION_CREATOR)->where(['=', 'id', 3])->asArray()->all());
//        _end(User::find()->with(User::RELATION_TASKS)->asArray()->all());

//        $data = User::find()->innerJoinWith(User::RELATION_TASKS)->asArray()->all();

//        $task = Task::findOne(2);
//       $data = $task->getAccessedUsers()->asArray()->all();

//        $task = Task::findOne(2);
//        $user = User::findOne(1);
//
//        $task->link(Task::RELATION_ACCESSED_USERS, $user);
//
//        $task = Task::findOne(2);
//        $data = $task->getAccessedUsers()->asArray()->all();

//        $task = Task::findOne(3);
//        $user = User::findOne(1);
//        $task->link(Task::RELATION_ACCESSED_USERS, $user);

//        return $this->render('test',
//            [
//                'data' => $data
//            ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        $model->setScenario(User::SCENARIO_CREATE);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->setScenario(User::SCENARIO_UPDATE);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
