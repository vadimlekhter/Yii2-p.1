<?php

namespace app\controllers;


use app\models\Product;
use Codeception\Module\Yii2;
use yii\db\Query;
use yii\web\Controller;
use yii\helpers\VarDumper;

class TestController extends Controller
{

    public function actionIndex()
    {
        //return 'Test';

        $testServiceResult = \Yii::$app->test->run();
//
//
        $product = new Product();
//
        $product->id = 1;
        $product->name = 'Куртка';
        $product->price = 100;
        $product->created_at = '12-12-1978';
//
//
//        $data = [
//            'id' => 1,
//            'name' => 'Тапок',
//            'price' => 10,
//            'created_at' => time(),
//        ];

        //$product->setAttributes($data);

        //$product->validate();
        //return VarDumper::dumpAsString($product->safeAttributes(), 4, true);
        //return VarDumper::dumpAsString($product->getAttributes(), 4, true);

//        $id = 2;
//        $price = 98;
//        $data = \Yii::$app->db->createCommand('update {{product}} set price = :price where id = :id',
//            [':price' => $price, ':id' => $id])->execute();

//        $query = new Query();
//        $data = $query->from ('product')->all();
//        _end($data);
//        _log($data);


//        \Yii::$app->db->createCommand()->insert('user', ['username' => 'John Smith', 'password_hash' => 'shdhdbnd',
//            'auth_key' => 'sdljfhshfjhgjhgj', 'creator_id' => 253576, 'updater_id' => 76476428, 'created_at' => 32198679823,
//            'updated_at' => 12857857]);

//        \Yii::info('ok', 'view');

        return $this->render('index',
            ['testServiceResult' => $testServiceResult,
                'describe' => 'Данные о товаре',
                'product' => $product,
            ]);
    }

    public function actionInsert()
    {

        \Yii::$app->db->createCommand()->insert('user', ['username' => 'John Smith', 'password_hash' => 'shdhdbnd',
            'creator_id' => 1, 'created_at' => 1])->execute();

        \Yii::$app->db->createCommand()->insert('user', ['username' => 'Mary White', 'password_hash' => 'shkljbnd',
            'creator_id' => 2, 'created_at' => 2])->execute();

        \Yii::$app->db->createCommand()->insert('user', ['username' => 'Jack Black', 'password_hash' => 'shdcbbnd',
            'creator_id' => 3, 'created_at' => 3])->execute();

        \Yii::$app->db->createCommand()->insert('user', ['username' => 'Ann Brown', 'password_hash' => 'shklmkod',
            'creator_id' => 4, 'created_at' => 4])->execute();

        $query = new Query();
        $data = $query->from('user')->all();

        \Yii::$app->db->createCommand()->batchInsert('task',
            ['title', 'description', 'creator_id', 'created_at'],
            [
                ['Task1', 'Wake Up', 1, 1],
                ['Task2', 'Have A Breakfast', 2, 2],
                ['Task3', 'Rest', 3, 3]
            ])->execute();

        $query = new Query();
        $data = $query->from('user')->all();
        
        $query = new Query();
        $data = $query->from('task')->all();


        return $this->render('insert',
            [
                'data' => $data,
            ]);
    }

    public function actionSelect()
    {
        $query = new Query();
        $data = $query->from('user')->where('id=:id', [":id" => 1])->all();

        $query = new Query();
        $data = $query->from('user')->where(['>', 'id', 1])->orderBy(['username' => SORT_ASC])->all();

        $query = new Query();
        $data = $query->from('user')->count();

        $query = new Query();
        $data = $query->from('user')->innerJoin('task',
            'user.id=task.creator_id')->all();


        return $this->render('select',
            [
                'data' => $data,
            ]);
    }
}
