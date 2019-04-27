<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accessed Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',

            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function (\app\models\Task $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id], ['class' => 'btn']);
                }
            ],

            'description:ntext',
            [
                'attribute' => 'Username',
                'format' => 'html',
                'value' => function (app\models\Task $model) {
                    $user = (int)$model->getCreator()->select('id')->column()[0][0];
                    $username = User::find()->select('username')->where(['id'=>$user])->asArray()->all()[0]['username'];
                    return Html::a($username, ['user/view', 'id' => $user], ['class' => 'btn']);
                }
            ],
//            'creator_id',
//            'updater_id',
            'created_at:datetime',
//            'updated_at:datetime',
//            'creator.username',




        ],
    ]); ?>
