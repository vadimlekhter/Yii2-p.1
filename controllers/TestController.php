<?php

namespace app\controllers;


use yii\web\Controller;
use app\models\Product;

class TestController extends Controller
{
    public function actionIndex()
    {
        //return 'Test';

        $product = new Product();
        $product->id = 1;
        $product->name = 'Куртка';
        $product->category = 'Одежда';
        $product->price = 100;


        return $this->render('index',
            [
                'describe' => 'Данные о товаре',
                'product' => $product
            ]);
    }
}
