<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaskUser */
/* @var $users array
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList($users) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
