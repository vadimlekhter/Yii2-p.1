<?php

/* @var $this yii\web\View */
/* @var $testService string */
/* @var $describe string */
/* @var $product \app\models\Product */

use \yii\widgets\DetailView;

$this->title = 'Test';
?>

<?= $testService ?>

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
echo $product->category;
echo '<br><br>';
echo $product->price;
echo '<br><br>';
?>

<?= DetailView::widget(['model' => $product]) ?>
