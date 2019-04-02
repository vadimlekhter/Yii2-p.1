<?php

/* @var $this yii\web\View */
/* @var $describe string */
/* @var $product \app\models\Product */

$this->title = 'Test';
?>

<h1>Товар</h1>

<?php
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

<?= \yii\widgets\DetailView::widget(['model' => $product]) ?>
