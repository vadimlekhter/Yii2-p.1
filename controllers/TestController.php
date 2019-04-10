<?php

namespace app\controllers;


use app\models\Product;
use Codeception\Module\Yii2;
use yii\web\Controller;
use yii\helpers\VarDumper;

class TestController extends Controller
{

    public function actionIndex()
    {
        //return 'Test';

        $testServiceResult = \Yii::$app->test->run();

        $product = new Product();
        $product->id = 1;
        $product->name = '        Куртка';
        $product->price = 100;
        $product->created_at = '12-12-1978';

        //$product->validate();
        //return VarDumper::dumpAsString($product->safeAttributes(), 4, true);
        //return VarDumper::dumpAsString($product->getAttributes(), 4, true);

        return $this->render('index',
            ['testServiceResult' => $testServiceResult,
                'describe' => 'Данные о товаре',
                'product' => $product,
            ]);
    }
}
