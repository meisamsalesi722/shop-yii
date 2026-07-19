<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\web\UploadedFile;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $mobile;
    public $imageFile;

    public function scenarios()
{
    return [
        'signup' => ['username', 'mobile', 'email', 'imageFile'],
        'update' => ['username', 'mobile', 'email', 'imageFile'],
    ];
}

    public function rules()
    {
        return [

            ['username', 'unique','targetClass' => User::class,'targetAttribute' => 'username','on' => 'update','filter' => function ($query) {
                    $query->andWhere(['!=', 'id', Yii::$app->user->id]);
                },
            ],

['username', 'unique',
    'targetClass' => User::class,
    'targetAttribute' => 'username',
    'on' => 'signup',
],

            [['username' , 'email'], 'required', 'on' => 'update'],
            [['mobile'], 'required' , 'on' => 'signup'],

            // ['mobile', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'mobile' , 'on' => 'update' , 'filter' => function ($query) {
            //     $query->andWhere(['!=', 'id', Yii::$app->user->id]);
            // },],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email' , 'on' => 'update' , 'filter' => function ($query) {
                $query->andWhere(['!=', 'id', Yii::$app->user->id]);
            },],
            ['username', 'string', 'min' => 3, 'max' => 100],
             [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp'],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $mobile = '+98' . ltrim($this->mobile , '0');
        $user->mobile = $mobile;
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

    public function edit($id)
    {
        if (!$this->validate()) {
            return null;
        }

                $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        $user = User::findOne($id);

                if($this->imageFile){
                    $this->deleteImage($id);
                    $imageName = time() . '.' . $this->imageFile->extension;
                    if (!file_exists('uploads/images')) {
                        mkdir('uploads/images', 0777, true);
                    }
                    
                    $this->imageFile->saveAs('uploads/images/' . $imageName);
                    $user->avatar = $imageName;

                }

        // if($user && Yii::$app->security->validatePassword($this->password, $user->password_hash)){
        $user->username = $this->username;
        $user->email = $this->email;
        // $user->mobile = $this->mobile;
        $user->generateAuthKey();
        return $user->save() ? $user : null;
        // }else{
        //     $this->addError('password', 'رمز عبور اشتباه است.');
        //     return null;
        // }
    }


    public function deleteImage($id)
    {
        $user = User::findOne($id);
        if ($user->avatar && file_exists('uploads/images/' . $user->avatar)) {
            return unlink('uploads/images/' . $user->avatar);
        }
        return false;
    }
}