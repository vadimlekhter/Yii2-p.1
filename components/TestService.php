<?php

namespace app\components;

use yii\base\Component;

class TestService extends Component
{
    public $comp = 'testService component';

    public function run()
    {
        return $this->comp;
    }
}