<?php

namespace app\modules\blog\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\modules\blog\models\User;
use app\modules\blog\models\Article;
use app\modules\blog\models\CommentBlog;
use app\modules\blog\models\BlogCategory;
use app\modules\blog\models\Favorite;


class DashboardController extends Controller
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
        ];
    }
    
    public function actionIndex()
    {
        // آمار کلی
        $totalArticles = Article::find()->count();
        $totalCategories = BlogCategory::find()->count();
        $totalComments = CommentBlog::find()->count();
        $totalUsers = User::find()->count();
        $totalFavorites = Favorite::find()->count();
        
        // آمار وضعیت‌ها
        $publishedArticles = Article::find()->where(['status' => 1])->count();
        $draftArticles = Article::find()->where(['status' => 0])->count();
        
        $pendingComments = CommentBlog::find()->where(['status' => CommentBlog::STATUS_PENDING])->count();
        $approvedComments = CommentBlog::find()->where(['status' => CommentBlog::STATUS_APPROVED])->count();
        $rejectedComments = CommentBlog::find()->where(['status' => CommentBlog::STATUS_REJECTED])->count();
        
        // آمار امروز
        $today = strtotime('today');
        $todayArticles = Article::find()->where(['>=', 'created_at', $today])->count();
        $todayComments = CommentBlog::find()->where(['>=', 'created_at', $today])->count();
        $todayUsers = User::find()->where(['>=', 'created_at', $today])->count();
        
        // آخرین مقالات
        $latestArticles = Article::find()
            ->with(['user', 'blog_category'])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();
        
        // آخرین کامنت‌ها
        $latestComments = CommentBlog::find()
            ->with(['user', 'article'])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();
        
        // جدیدترین کاربران
        $latestUsers = User::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();
        
        // مقالات محبوب (بیشترین کامنت)
        $popularArticles = Article::find()
            ->select(['article.*', 'COUNT(comment_blog.id) as comment_count'])
            ->leftJoin('comment_blog', 'comment_blog.article_id = article.id')
            ->where(['article.status' => 1])
            ->groupBy('article.id')
            ->orderBy(['comment_count' => SORT_DESC])
            ->limit(5)
            ->all();
        
        // دسته‌بندی‌های پرکاربرد
        $popularCategories = BlogCategory::find()
            ->select(['blog_category.*', 'COUNT(article.id) as article_count'])
            ->leftJoin('article', 'article.blog_category_id = blog_category.id')
            ->groupBy('blog_category.id')
            ->orderBy(['article_count' => SORT_DESC])
            ->limit(5)
            ->all();
        
        // آمار ماهانه
        $monthlyStats = $this->getMonthlyStats();
        
        return $this->render('index', [
            'totalArticles' => $totalArticles,
            'totalCategories' => $totalCategories,
            'totalComments' => $totalComments,
            'totalUsers' => $totalUsers,
            'totalFavorites' => $totalFavorites,
            'publishedArticles' => $publishedArticles,
            'draftArticles' => $draftArticles,
            'pendingComments' => $pendingComments,
            'approvedComments' => $approvedComments,
            'rejectedComments' => $rejectedComments,
            'todayArticles' => $todayArticles,
            'todayComments' => $todayComments,
            'todayUsers' => $todayUsers,
            'latestArticles' => $latestArticles,
            'latestComments' => $latestComments,
            'latestUsers' => $latestUsers,
            'popularArticles' => $popularArticles,
            'popularCategories' => $popularCategories,
            'monthlyStats' => $monthlyStats,
        ]);
    }
    
    private function getMonthlyStats()
    {
        $stats = [];
        for ($i = 6; $i >= 0; $i--) {
            $month = strtotime("-$i months");
            $monthStart = strtotime(date('Y-m-01', $month));
            $monthEnd = strtotime(date('Y-m-t', $month));
            
            $stats[] = [
                'month' => date('F', $month),
                'articles' => Article::find()
                    ->where(['between', 'created_at', $monthStart, $monthEnd])
                    ->count(),
                'comments' => CommentBlog::find()
                    ->where(['between', 'created_at', $monthStart, $monthEnd])
                    ->count(),
                'users' => User::find()
                    ->where(['between', 'created_at', $monthStart, $monthEnd])
                    ->count(),
            ];
        }
        return $stats;
    }
}