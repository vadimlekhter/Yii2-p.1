<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'My Tasks', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'creator_id',
            'updater_id',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>




    <?php
    if (!$dataProvider == null) {
        echo '<h2>Task shared for</h2>';
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'user.username',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model, $id) {
                            $icon = \yii\bootstrap\Html::icon('remove');
                            return Html::a($icon, ['task-user/delete', 'id' => $model->id], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to unshare this user?',
                                    'method' => 'post',
                                ]]);
                        }
                    ]
                ],
            ],
        ]);
    }
    ?>
</div>
