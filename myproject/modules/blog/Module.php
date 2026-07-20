<?php 
namespace app\modules\blog;

use Yii;
use yii\base\Module as ModuleClass;

class Module extends ModuleClass
{
    public $controllerNamespace = 'app\modules\blog\controllers';

    public function init()
    {
        Yii::$app->set('db_blog', [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ]);
        parent::init();
        $this->setViewPath('@app/modules/blog/views');
    }
}