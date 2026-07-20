<?php

namespace app\modules\blog\controllers\admin;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use app\modules\blog\models\User;
use yii\web\NotFoundHttpException;


class RbacController extends Controller
{
    public $layout = '/admin/admin';
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    // 'assign' => ['POST'],
                    // 'revoke' => ['POST'],
                    'delete-role' => ['POST'],
                    'delete-permission' => ['POST'],
                ],
            ],
        ];
    }

    /**
 * مشاهده جزئیات نقش
 */
public function actionViewRole($name)
{
    $auth = Yii::$app->authManager;
    $role = $auth->getRole($name);
    
    if (!$role) {
        throw new NotFoundHttpException('نقش مورد نظر پیدا نشد.');
    }
    
    // دریافت دسترسی‌های نقش
    $permissions = $auth->getPermissionsByRole($name);
    
    // دریافت کاربرانی که این نقش را دارند
    $userIds = $auth->getUserIdsByRole($name);
    $users = [];
    if ($userIds) {
        $users = \app\models\User::find()->where(['id' => $userIds])->all();
    }
    
    return $this->render('view-role', [
        'role' => $role,
        'permissions' => $permissions,
        'users' => $users,
    ]);
}
    
    /**
     * لیست تمام نقش‌ها
     */
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $roles,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['name', 'description', 'createdAt'],
            ],
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'roles' => $roles,
        ]);
    }
    
    /**
     * ایجاد نقش جدید
     */
    public function actionCreateRole()
    {
        $auth = Yii::$app->authManager;
        $permissions = $auth->getPermissions();
        
        if (Yii::$app->request->isPost) {
            $name = Yii::$app->request->post('name');
            $description = Yii::$app->request->post('description');
            $selectedPermissions = Yii::$app->request->post('permissions', []);
            
            // بررسی تکراری نبودن
            if ($auth->getRole($name)) {
                Yii::$app->session->setFlash('error', 'این نقش قبلاً وجود دارد.');
                return $this->redirect(['create-role']);
            }
            
            $role = $auth->createRole($name);
            $role->description = $description;
            $auth->add($role);
            
            // اضافه کردن دسترسی‌ها
            foreach ($selectedPermissions as $permName) {
                $permission = $auth->getPermission($permName);
                if ($permission) {
                    $auth->addChild($role, $permission);
                }
            }
            
            Yii::$app->session->setFlash('success', 'نقش با موفقیت ایجاد شد.');
            return $this->redirect(['index']);
        }
        
        return $this->render('create-role', [
            'permissions' => $permissions,
        ]);
    }
    
    /**
     * ویرایش نقش
     */
    public function actionUpdateRole($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        
        if (!$role) {
            throw new NotFoundHttpException('نقش مورد نظر پیدا نشد.');
        }
        
        $permissions = $auth->getPermissions();
        $rolePermissions = $auth->getPermissionsByRole($name);
        $rolePermissionNames = array_keys($rolePermissions);
        
        if (Yii::$app->request->isPost) {
            $description = Yii::$app->request->post('description');
            $selectedPermissions = Yii::$app->request->post('permissions', []);
            
            $role->description = $description;
            $auth->update($name, $role);
            
            // حذف دسترسی‌های قبلی
            foreach ($rolePermissions as $perm) {
                $auth->removeChild($role, $perm);
            }
            
            // اضافه کردن دسترسی‌های جدید
            foreach ($selectedPermissions as $permName) {
                $permission = $auth->getPermission($permName);
                if ($permission) {
                    $auth->addChild($role, $permission);
                }
            }
            
            Yii::$app->session->setFlash('success', 'نقش با موفقیت ویرایش شد.');
            return $this->redirect(['index']);
        }
        
        return $this->render('update-role', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissionNames,
        ]);
    }
    
    /**
     * حذف نقش
     */
    public function actionDeleteRole($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        
        if ($role) {
            $auth->remove($role);
            Yii::$app->session->setFlash('success', 'نقش با موفقیت حذف شد.');
        }
        
        return $this->redirect(['index']);
    }
    
    /**
     * تخصیص نقش به کاربران
     */
    public function actionAssign()
    {
        $auth = Yii::$app->authManager;
        $users = User::find()->all();
        $roles = $auth->getRoles();
        
        return $this->render('assign', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
    
    /**
     * اختصاص نقش به کاربر (Ajax)
     */
    public function actionAssignRole()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $userId = Yii::$app->request->post('user_id');
        $roleName = Yii::$app->request->post('role_name');
        
        if (!$userId || !$roleName) {
            return ['success' => false, 'message' => 'اطلاعات ناقص است.'];
        }
        
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        
        if (!$role) {
            return ['success' => false, 'message' => 'نقش مورد نظر پیدا نشد.'];
        }
        
        // بررسی اینکه کاربر قبلاً این نقش را دارد
        if ($auth->getAssignment($roleName, $userId)) {
            return ['success' => false, 'message' => 'این نقش قبلاً به کاربر اختصاص داده شده است.'];
        }
        
        $auth->assign($role, $userId);
        
        return [
            'success' => true,
            'message' => 'نقش با موفقیت به کاربر اختصاص داده شد.'
        ];
    }
    
    /**
     * لغو نقش از کاربر (Ajax)
     */
    public function actionRevokeRole()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $userId = Yii::$app->request->post('user_id');
        $roleName = Yii::$app->request->post('role_name');
        
        if (!$userId || !$roleName) {
            return ['success' => false, 'message' => 'اطلاعات ناقص است.'];
        }
        
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        
        if (!$role) {
            return ['success' => false, 'message' => 'نقش مورد نظر پیدا نشد.'];
        }
        
        $assignment = $auth->getAssignment($roleName, $userId);
        if (!$assignment) {
            return ['success' => false, 'message' => 'این نقش به کاربر اختصاص داده نشده است.'];
        }
        
        $auth->revoke($role, $userId);
        
        return [
            'success' => true,
            'message' => 'نقش با موفقیت از کاربر لغو شد.'
        ];
    }
    
    /**
     * دریافت نقش‌های یک کاربر (Ajax)
     */
    public function actionGetUserRoles()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $userId = Yii::$app->request->post('user_id');
        
        if (!$userId) {
            return ['success' => false, 'message' => 'شناسه کاربر ارسال نشده است.'];
        }
        
        $auth = Yii::$app->authManager;
        $userRoles = $auth->getRolesByUser($userId);
        $allRoles = $auth->getRoles();
        
        return [
            'success' => true,
            'userRoles' => array_keys($userRoles),
            'allRoles' => array_keys($allRoles),
        ];
    }
}