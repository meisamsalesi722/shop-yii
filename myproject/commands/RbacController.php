<?php

namespace app\commands;

use Yii;

class RbacController extends \yii\console\Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // ================= PERMISSIONS =================
        $createArticle = $auth->createPermission('createArticle');
        $auth->add($createArticle);

        $updateArticle = $auth->createPermission('updateArticle');
        $auth->add($updateArticle);

        $deleteArticle = $auth->createPermission('deleteArticle');
        $auth->add($deleteArticle);

        // ================= ROLES =================

        // WRITER
        $writer = $auth->createRole('writer');
        $auth->add($writer);

        $auth->addChild($writer, $createArticle);
        $auth->addChild($writer, $updateArticle);

        // EDITOR
        $editor = $auth->createRole('editor');
        $auth->add($editor);

        $auth->addChild($editor, $updateArticle);

        // ADMIN
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->addChild($admin, $createArticle);
        $auth->addChild($admin, $updateArticle);
        $auth->addChild($admin, $deleteArticle);

        // ================= ASSIGN =================
        $auth->assign($admin, 1);
    }
}