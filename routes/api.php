<?php

use App\Http\Controllers\Api\AuthorizationsController;
use App\Http\Controllers\Api\CaptchasController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ImagesController;
use App\Http\Controllers\Api\TopicsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\VerificationCodesController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

// API
Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1.')
    ->group(function () {

        // 登录相关
        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function () {
                // 图片验证码
                Route::post('captchas', [CaptchasController::class, 'store'])
                    ->name('captchas.store');
                // 短信验证码
                Route::post('verificationCodes', [VerificationCodesController::class, 'store'])
                    ->name('verificationCodes.store');
                // 用户注册
                Route::post('users', [UsersController::class, 'store'])
                    ->name('users.store');
                // 用户注册
                Route::post('users', [UsersController::class, 'store'])
                    ->name('users.store');
                // 第三方登录
                Route::post('socials/{social_type}/authorizations', [AuthorizationsController::class, 'socialStore'])
                    ->where('social_type', 'wechat|weibo')  // 第三方登陆 支持微信及微博
                    ->name('socials.authorizations.store');
                // 登录
                Route::post('authorizations', [AuthorizationsController::class, 'store'])
                    ->name('authorizations.store');
                // 刷新token
                Route::put('authorizations/current', [AuthorizationsController::class, 'update'])
                    ->name('authorizations.update');
                // 删除token
                Route::delete('authorizations/current', [AuthorizationsController::class, 'destroy'])
                    ->name('authorizations.destroy');
            });

        // 访问相关
        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {
                // 游客可以访问的接口

                // 话题列表，详情
                Route::get('topics', [TopicsController::class, 'index']);
                Route::get('topics/{topic}/{slug?}', [TopicsController::class, 'show']);

                // 某个用户的详情
                Route::get('users/{user}', [UsersController::class, 'show'])
                    ->name('users.show');
                // 分类列表
                Route::get('categories', [CategoriesController::class, 'index'])
                    ->name('categories.index');

                // 登录后可以访问的接口
                Route::middleware('auth:api')->group(function() {
                    // 当前登录用户信息
                    Route::get('user', [UsersController::class, 'me'])
                        ->name('user.show');
                    // 编辑登录用户信息
                    Route::patch('user', [UsersController::class, 'update'])
                        ->name('user.update');
                    // 上传图片
                    Route::post('images', [ImagesController::class, 'store'])
                        ->name('images.store');
                    Route::post('topics', [TopicsController::class, 'store']);
                    Route::patch('topics/{topic}', [TopicsController::class, 'update']);
                    Route::delete('topics/{topic}', [TopicsController::class, 'destroy']);
                });
            });

    });
