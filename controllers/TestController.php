<?php

namespace app\controllers;


use app\models\Test;
use Codeception\Module\Yii2;
use yii\web\Controller;

class TestController extends Controller
{

    public $testService;
    public function actionIndex()
    {
        //return 'Test';

        $this->testService = \Yii::$app->test->run();

        $product = new Test();
        $product->id = 1;
        $product->name = 'Куртка';
        $product->category = 'Одежда';
        $product->price = 100;

        return $this->render('index',
            ['testService' =>$this->testService,
                'describe' => 'Данные о товаре',
                'product' => $product
            ]);
    }
}
