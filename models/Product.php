<?php


namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Product is the model behind the Test.
 */
class Product extends Model
{
    public $id;
    public $name;
    public $category;
    public $price;
}