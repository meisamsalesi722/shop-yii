<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }




    /**
 * دریافت نقش‌های کاربر
 */
public function getRoles()
{
    $auth = Yii::$app->authManager;
    return $auth->getRolesByUser($this->id);
}

/**
 * بررسی اینکه کاربر نقش خاصی دارد
 */
public function hasRole($roleName)
{
    $auth = Yii::$app->authManager;
    $roles = $auth->getRolesByUser($this->id);
    return isset($roles[$roleName]);
}

/**
 * اختصاص نقش به کاربر
 */
public function assignRole($roleName)
{
    $auth = Yii::$app->authManager;
    $role = $auth->getRole($roleName);
    if ($role) {
        $auth->assign($role, $this->id);
        return true;
    }
    return false;
}

/**
 * لغو نقش از کاربر
 */
public function revokeRole($roleName)
{
    $auth = Yii::$app->authManager;
    $role = $auth->getRole($roleName);
    if ($role) {
        $auth->revoke($role, $this->id);
        return true;
    }
    return false;
}

/**
 * دریافت لیست کاربران بر اساس نقش
 */
public static function getUsersByRole($roleName)
{
    $auth = Yii::$app->authManager;
    $users = [];
    $assignments = $auth->getUserIdsByRole($roleName);
    if ($assignments) {
        $users = self::find()->where(['id' => $assignments])->all();
    }
    return $users;
}

}