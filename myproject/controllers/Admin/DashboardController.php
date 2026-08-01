<?php

namespace app\controllers\admin;

use Yii;
use app\models\User;
use app\models\Comment;
use app\models\Product;
use yii\web\Controller;
use app\models\Category;
use app\models\Favorite;
use app\models\OrderItem;
use app\models\Vendor;
use app\models\VendorProduct;
use yii\filters\AccessControl;

class DashboardController extends Controller
{
    public $layout = 'admin/admin';
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        // آمار کلی
        $totalProducts = Product::find()->count();
        $totalCategories = Category::find()->count();
        $totalComments = Comment::find()->count();
        $totalUsers = User::find()->count();
        
        // آمار وضعیت‌ها
        $publishedProducts = Product::find()->where(['status' => 1])->count();
        $draftProducts = Product::find()->where(['status' => 0])->count();
        
        $pendingComments = Comment::find()->where(['status' => Comment::STATUS_PENDING])->count();
        $approvedComments = Comment::find()->where(['status' => Comment::STATUS_APPROVED])->count();
        $rejectedComments = Comment::find()->where(['status' => Comment::STATUS_REJECTED])->count();

        $pendingProduct = Product::find()->where(['status' => 0])->count();
        $approvedProduct = Product::find()->where(['status' => 1])->count();
        $rejectedProduct = Product::find()->where(['status' => 2])->count();
        
        // آمار امروز
        $today = date("y/m/d h:i:s"); 
        $todayProducts = Product::find()->where(['>=', 'created_at', $today])->count();
        $todayComments = Comment::find()->where(['>=', 'created_at', $today])->count();
        $todayUsers = User::find()->where(['>=', 'created_at', $today])->count();
        
        // آخرین مقالات
        $latestProducts = Product::find()
            ->with(['category'])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();
        
        // آخرین کامنت‌ها
        $latestComments = Comment::find()
            ->with(['user', 'product'])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();
        
        // جدیدترین کاربران
        $latestUsers = User::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();
        
        // مقالات محبوب (بیشترین کامنت)
        $popularProducts = Product::find()
            ->select(['product.*', 'COUNT(comment.id) as comment_count'])
            ->leftJoin('comment', 'comment.product_id = product.id')
            ->where(['product.status' => 1])
            ->groupBy('product.id')
            ->orderBy(['comment_count' => SORT_DESC])
            ->limit(5)
            ->all();
        
        // دسته‌بندی‌های پرکاربرد
        $popularCategories = Category::find()
            ->select(['category.*', 'COUNT(product.id) as product_count'])
            ->leftJoin('product', 'product.category_id = category.id')
            ->groupBy('category.id')
            ->orderBy(['product_count' => SORT_DESC])
            ->limit(5)
            ->all();

            $vendorsAproved = Vendor::find()->where(['status' => 1])->count();
            $vendorsrejected = Vendor::find()->where(['status' => 2])->count();
            $vendorspending = Vendor::find()->where(['status' => 0])->count();
            $bestsellers = Product::find()
                ->select([
                    'product.*',
                    'total_sold' => 'SUM(vendor_product.sold_number)',
                ])
                ->joinWith('productVariants.vendorProducts')
                ->where(['product.status' => 1])
                ->groupBy('product.id')
                ->orderBy(['total_sold' => SORT_DESC])
                ->limit(10)
                ->all();

                $bestsellersItem = [];
                foreach ($bestsellers as $bestseller) {
                $bestsellersItem[] = [
                    'name' => $bestseller->name,
                    'count' => $bestseller->total_sold,
                ];
            }

            $orderItemCount = $this->getOrderItemCount();
            
        
        // آمار ماهانه
        $monthlyStats = $this->getMonthlyStats();
        
        return $this->render('index', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalComments' => $totalComments,
            'totalUsers' => $totalUsers,
            'publishedProducts' => $publishedProducts,
            'draftProducts' => $draftProducts,
            'pendingComments' => $pendingComments,
            'approvedComments' => $approvedComments,
            'rejectedComments' => $rejectedComments,
            'todayProducts' => $todayProducts,
            'todayComments' => $todayComments,
            'todayUsers' => $todayUsers,
            'latestProducts' => $latestProducts,
            'latestComments' => $latestComments,
            'latestUsers' => $latestUsers,
            'popularProducts' => $popularProducts,
            'popularCategories' => $popularCategories,
            'monthlyStats' => $monthlyStats,
            'pendingProduct' => $pendingProduct ,
            'rejectedProduct' => $rejectedProduct ,
            'approvedProduct' => $approvedProduct ,
            'orderItemCount' => $orderItemCount ,
            'vendorspending' => $vendorspending ,
            'vendorsrejected' => $vendorsrejected ,
            'vendorsAproved' => $vendorsAproved ,
            'bestsellers' => $bestsellers ,
            'bestsellersItem' => $bestsellersItem ,
        ]);
    }
    
    private function getMonthlyStats()
    {
        $stats = [];
        for ($i = 6; $i >= 0; $i--) {
            $month = strtotime("-$i months");
            $monthStart = date('Y-m-01', $month);
            $monthEnd = date('Y-m-t', $month);
            
            $stats[] = [
                'month' => date('F', $month),
                'products' => Product::find()
                    ->where(['between', 'created_at', $monthStart, $monthEnd])
                    ->count(),
                'comments' => Comment::find()
                    ->where(['between', 'created_at', $monthStart, $monthEnd])
                    ->count(),
                'users' => User::find()
                    ->where(['between', 'created_at', $monthStart, $monthEnd])
                    ->count(),
            ];
        }
        return $stats;
    }

    public function getOrderItemCount(){

        $stats = [];
        for($i = 0 ; $i <= 5 ; $i++){
            $month = strtotime("-$i months");
            $monthStart = date('Y-m-01', $month);
            $monthEnd = date('Y-m-t', $month);
            
            $orderItemsNotPaid = OrderItem::find()->joinWith('order')->where(['between' , 'order_item.created_at' , $monthStart , $monthEnd])->andWhere(['order.payment_status' => 0])->all();
            $orderItemspaid = OrderItem::find()->joinWith('order')->where(['between' , 'order_item.created_at' , $monthStart , $monthEnd])->andWhere(['order.payment_status' => 1])->all();
            $countNotPaid = 0;
            $countpaid = 0;
            foreach($orderItemsNotPaid as $orderItemNotPaid){
                $countNotPaid += $orderItemNotPaid->number;
            }
            foreach($orderItemspaid as $orderItempaid){
                $countpaid += $orderItempaid->number;
            }

            $stats[] = [
                'mount' => date('F', $month),
                'orderItemsNotPaid' => $countNotPaid,
                'orderItemspaid' => $countpaid,
            ];
        }

        return $stats;
    }
}