<?php

use App\Http\Controllers\Achievements\AchievementController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TariffController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Callback\CallbackController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Companies\CompanyAuthController;
use App\Http\Controllers\Companies\CompanyEditSectionController;
use App\Http\Controllers\Companies\CompanyListController;
use App\Http\Controllers\Companies\SearchCompanyController;
use App\Http\Controllers\Social\SocialController;
use App\Http\Controllers\Stories\StoryController;
use App\Http\Controllers\Subscription\BuySubscriptionController;
use App\Http\Controllers\Users\UserProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});


Route::get('companies', [SearchCompanyController::class, 'index']);
Route::get('search', [SearchCompanyController::class, 'search']);
Route::post('files', [CompanyEditSectionController::class, 'storeFile']);
Route::post('avatars', [UserProfileController::class, 'uploadAvatar']);
Route::post('buy/subscription', [BuySubscriptionController::class, 'index']);
Route::post('send/message', [CallbackController::class, 'sendTextMessage']);
Route::post('send/voice-message', [CallbackController::class, 'sendVoiceMessage']);
Route::post('add-story', [StoryController::class, 'addStoryFile']);
Route::post('add-product-image', [ProductController::class, 'addProductFile']);

Route::post('company/settings', [CompanyEditSectionController::class, 'updateCompanyData']);
Route::post('user/settings', [UserProfileController::class, 'updateUserProfileData']);
Route::get('profile/{id}', [UserProfileController::class, 'getProfileData']);
Route::resource('admin/products', ProductController::class);
Route::get('admin/get/products/{id}', [\App\Http\Controllers\Products\ProductController::class, 'getProducts']);
Route::resource('admin/advertisement', AdvertisementController::class);
Route::get('get/advertisement/{id}', [StoryController::class, 'getData']);
Route::post('admin/add-advertisement-{id}', [StoryController::class, 'store']);
Route::resource('admin/users', UserController::class);
Route::resource('admin/achievements', AchievementController::class);
Route::post('add-achievement-image', [AchievementController::class, 'addAchievementFile']);
Route::get('admin/get/achievements/{id}', [AchievementController::class, 'getData']);

//Route::get('upload/products/{id}', [\App\Http\Controllers\Products\ProductController::class, 'getCompany']);
Route::get('upload/products', [\App\Http\Controllers\Products\ProductController::class, 'uploadProducts'])->name('uploadProducts');
Route::post('sort/companies', [\App\Http\Controllers\Users\UserController::class, 'getCompanies']);
Route::get('products', [\App\Http\Controllers\Products\ProductController::class, 'getProductsAndCategories']);
Route::get('products/category/{id}', [\App\Http\Controllers\Products\ProductController::class, 'getProductsByCategory']);
Route::get('user/companies/{id}', [\App\Http\Controllers\Users\UserController::class, 'getUsersCompanies']);
Route::delete('user/{user}/company/{id}', [\App\Http\Controllers\Users\UserController::class, 'deleteCompany']);
Route::post('debiting/cashback', [\App\Http\Controllers\Cashback\CashBackController::class, 'debitingCashback']);
Route::post('offs/cashback', [\App\Http\Controllers\Cashback\CashBackController::class, 'offsCashback']);
Route::post('description/photo', [\App\Http\Controllers\Cashback\CashBackController::class, 'loadDescriptionPhoto']);
Route::get('profile/products/{id}', [UserProfileController::class, 'getProducts']);
Route::post('add/company/admin', [\App\Http\Controllers\Admin\CompanyAdminsController::class, 'addCompanyAdmin']);
Route::post('delete/company/admin', [\App\Http\Controllers\Admin\CompanyAdminsController::class, 'deleteCompanyAdmin']);
Route::get('change/active-admin/{admin}/{company}', [\App\Http\Controllers\Admin\CompanyAdminsController::class, 'changeActiveAdmin']);
Route::get('active/admins/company/{id}', [\App\Http\Controllers\Companies\CompanyProfileController::class, 'getActiveAdmins']);
Route::post('change/email', [UserProfileController::class, 'changeUserEmail']);
Route::post('change/avatar', [UserProfileController::class, 'changeUserAvatar']);
Route::get('qrcode/{user}/{company}', [\App\Http\Controllers\Companies\CompanyProfileController::class, 'getUserCompanyPromocode']);
Route::get('balance/user/{id}/{company}', [\App\Http\Controllers\Cashback\CashBackController::class, 'getUserBalance']);
Route::delete('action/delete/{id}', [\App\Http\Controllers\HistoryAction\HistoryActionController::class, 'deleteAction']);
Route::get('actions/{id}', [\App\Http\Controllers\HistoryAction\HistoryActionController::class, 'getActions']);

Route::post('/payments', [TariffController::class, 'store'])->name('payments-store');
Route::post('/payments/cancel', [TariffController::class, 'cancel'])->name('payments-cancel');
Route::post('/payments/resume', [TariffController::class, 'resume'])->name('payments-resume');


