<?php

use App\Http\Controllers\Achievements\AchievementController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\CompanyActionMenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TariffController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Companies\CompanyAuthController;
use App\Http\Controllers\Companies\CompanyEditSectionController;
use App\Http\Controllers\Companies\CompanyListController;
use App\Http\Controllers\Companies\CompanyProfileController;
use App\Http\Controllers\HistoryAction\HistoryActionController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Promocode\PromocodeController;
use App\Http\Controllers\Region\RegionMapController;
use App\Http\Controllers\Social\SocialController;
use App\Http\Controllers\Stories\StoryController;
use App\Http\Controllers\Users\UserProfileController;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* Группа всех пользователей */
//Route::group(['middleware' => ['web', 'setLocale'], 'prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}']], function () {
Route::group(['middleware' => ['web', 'setLocale']], function () {
    /* Рекламная страница приложения */
    Route::get('/landing-page', function () {
        return view('pages/landingPage');
    });
    Route::get('/locale', [\App\Http\Controllers\LangController::class, 'getLang']);
    Route::get('/locales', [\App\Http\Controllers\LangController::class, 'getLocales']);
    Route::get('/locale/{lang}', [\App\Http\Controllers\LangController::class, 'setLang']);
    /* Главная страница */
    Route::get('/', [\App\Http\Controllers\Users\UserController::class, 'getAuthUser']);
    Route::get('/activity-history', [\App\Http\Controllers\ActivityHistory\ActivityHistoryController::class, 'getActivityHistory']);
    /* О нас */
    Route::get('/about-project', function () {
        return view('pages/aboutProjectPage');
    });
    /* Товары (продающая страница) */
    Route::get('/products', function () {
        return view('pages/products/ProductsPage');
    });
    Route::get('products/category/{id}', [\App\Http\Controllers\Products\ProductController::class, 'getProductsByCategory']);
    /* Новости (рекламные банеры) */
    Route::get('/news', [NewsController::class, 'getNews']);
    Route::get('/news/{id}', [NewsController::class, 'getNewsItem']);
    /* Страница компаний */
    Route::get('/search-company', [CompanyListController::class, 'getSearchPage']);
    /* Профиль компании */
    Route::get('/company-profile-{id}', [CompanyProfileController::class, 'getCompanyData'])->name('company-profile');
    Route::get('/qr-handler/data={data}', [PromocodeController::class, 'qrHandler'])->name('qr-handler');
    /* Авторизация через социальные сети */
    Route::get('/auth/{driver}', [SocialController::class, 'index']);
    Route::get('/auth/{driver}/callback', [SocialController::class, 'callback']);
    Route::get('/complete-register-{email}', [SocialController::class, 'complete']);
    /*Страница с картой*/
    Route::get('/region-map/{id}', [RegionMapController::class, 'getMap']);
    /* Группа авторизованных пользователей */
    Route::group(['middleware' => ['auth']], function () {
        Route::post('/save-push-notification-token', [NotificationController::class, 'savePushNotificationToken'])->name('save-push-notification-token');
        /* Профиль пользователя */
        Route::get('/user-profile', [UserProfileController::class, 'getAuthUser'])->name('profile');
        Route::get('/company/add-{id}', [CompanyListController::class, 'addUserCompany']);
        /* Настройки профиля пользователя */
        Route::get('/user-settings', [UserProfileController::class, 'getUserSettings']);
        /*Страница редактирования данных о профиле пользователя*/
        Route::get('/user-edit', [UserProfileController::class, 'index']);
        /* Достижения пользователя */
        Route::get('/achievements', function () {
            return view('pages/userProfile/achievements/achievementPage');
        });
        Route::get('/achievements/achievements-{id}', [AchievementController::class, 'getAchievement']);
        /* История действий пользователя */
        Route::get('/history',[HistoryActionController::class, 'getActionsPage']);
        Route::get('/history/action-{id}', [HistoryActionController::class, 'getActionDetail']);
        /* Друзья пользователя */
        Route::get('/friends', [\App\Http\Controllers\Users\UserFriendsController::class, 'getUserFriendsPage']);
        /* Дерево друзей пользователя */
        Route::get('/friends-tree/{company}', [\App\Http\Controllers\Users\UserFriendsController::class, 'getUserFriendsTreePage']);
        /* Страница ввода промокода */
        Route::get('/promo-code/{user}/{company}', [PromocodeController::class, 'getUserPromocode'])->name('user-qr');
        /* Регистрация компании */
        Route::get('/register-company', function () {
            return view('auth/companyAuth/RegistrationCompanyPage');
        });
        Route::post('/register-company', [CompanyAuthController::class, 'register']);
        Route::post('/login-company', [CompanyAuthController::class, 'login']);
        /* Авторизация компании */
        Route::get('/login-company', function () {
            return view('auth/companyAuth/LoginCompanyPage');
        });
        Route::group(['middleware' => ['company.admin']], function () {
            Route::group(['middleware' => ['company.subscribed']], function () {
                Route::get('/register-complete-company-{id}', [CompanyAuthController::class, 'completeRegistration'])->name('completeCompanyRegistration');
                /* Страница добавления рекламы (Степер) */
                Route::get('/add-advertising-{id}', [StoryController::class, 'getStepperPage']);
                /* Страница редактирования данных о компании */
                Route::get('/company-edit-{id}', [CompanyEditSectionController::class, 'index']);
                /* Меню админа компании */
                Route::get('/company-admin-menu-{id}', [CompanyActionMenuController::class, 'adminMenu'])->name('company-admin');
                /*CRUD продукты*/
                Route::get('/company-admin-products-{id}', [ProductController::class, 'index'])->name('companyProducts');
                Route::get('/token-company-{id}', [\App\Http\Controllers\Products\ProductController::class, 'getUserToken']);
                /*CRUD реклама*/
                Route::get('/company-admin-advertisement-{id}', [AdvertisementController::class, 'index']);
                /*Просмотр пользователей админом*/
                Route::get('/company-admin-users-{id}', [UserController::class, 'index']);
                /*Страница историй админа*/
                Route::get('/story-admin-menu-{id}', [AdvertisementController::class, 'getAdvertisement']);
                /*Страница действий компании*/
                Route::get('/company-action-menu-{id}', [CompanyActionMenuController::class, 'index']);
                /*Страница списка администраторов компании*/
                Route::get('/company-group-admin-{id}', [\App\Http\Controllers\Admin\CompanyAdminsController::class, 'getCompanyGroupAdmin']);
            });
            Route::get('/company-tariffs-{id}', [TariffController::class, 'getPage'])->name('company-tariffs');
        });
        Route::get('/upload-products', [\App\Http\Controllers\Products\ProductController::class, 'uploadProducts'])->name('companyUploadProducts');
        /*Страница добавления промокода*/
        Route::get('/add-promocode', [PromocodeController::class, 'index']);
    });

    Auth::routes();

    Route::group(['prefix' => 'admin'], function () {
        Voyager::routes();
    });
});
