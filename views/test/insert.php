<?php

/* @var $this yii\web\View */

use \yii\widgets\DetailView;
use \yii\helpers\Html;

$this->title = 'Test-Insert';
?>

    <p>
        <?= Html::a('Test', ['index'], ['class' => 'btn btn-info']) ?>
    </p>

<?php


echo yii\helpers\VarDumper::dumpAsString($data, 5, 'true');
