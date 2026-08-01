<?php 
namespace app\modules\ticket;

use yii\base\Module as ModuleClass;

class Module extends ModuleClass
{
    public $controllerNamespace = 'app\modules\ticket\controllers';

    public function init()
    {
        parent::init();
        $this->setViewPath('@app/modules/ticket/views');
    }
}