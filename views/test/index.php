<?php

/* @var $this yii\web\View */
/* @var $product \app\models\Product */

use \yii\widgets\DetailView;
use \yii\helpers\Html;

$this->title = 'Test';
?>

<div>
<span>
    <?= Html::a('Insert User', ['insert'], ['class' => 'btn btn-success']) ?>
</span>

<span>
    <?= Html::a('Select User', ['select'], ['class' => 'btn btn-primary']) ?>
</span>
</div>

<?= $testServiceResult ?>

<h1>Товар</h1>

<?php
echo '<br><br>';
echo $describe;
echo ': ';
echo $product->name;
echo '<br><br>';
echo $product->id;
echo '<br><br>';
echo $product->name;
echo '<br><br>';
echo $product->price;
echo '<br><br>';
echo $product->created_at;
echo '<br><br>';
?>

<?= DetailView::widget(['model' => $product]) ?>
