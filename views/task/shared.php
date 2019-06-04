<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shared Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function (\app\models\Task $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id], ['class' => 'btn']);
                }
            ],
            'description:ntext',
            [
                'label' => 'Shared to Users',
                'value' => function (app\models\Task $model) {
//                    return join(', ', $model->getAccessedUsers()->select('username')->column());
                    $sharedUsers = array();
                    foreach ($model->getAccessedUsers()->select(['username', 'id'])->asArray()->all() as $user) {
                        array_push($sharedUsers, Html::a($user['username'], ['user/view', 'id' => $user->id]));
                    };
                    return join(', ', $sharedUsers);
                },
                'format' => 'html'
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {unshare}',
                'buttons' => [
                    'unshare' => function ($url, $model, $id) {
                        $icon = \yii\bootstrap\Html::icon('remove');
                        return Html::a($icon, ['task-user/unshare-all', 'taskId' => $model->id], [
                            'data' => [
                                'confirm' => 'Are you sure you want to unshare this task?',
                                'method' => 'post',
                            ]]);
                    }
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>