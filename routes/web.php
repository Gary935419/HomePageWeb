<?php

use Illuminate\Support\Facades\Route;

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

//Apiに関連するルーティングの配置です。
Route::middleware(['req.trim'])->group(function () {
    Route::group(['prefix' => 'webapi'], function ($app) {
        $app->post('topics/topics_search', 'api\web\TopicsController@post_topics_search');
        $app->post('download/download_from_add', 'api\web\DownloadController@post_download_from_add');
        $app->post('inquiry/inquiry_add', 'api\web\InquiryController@post_inquiry_add');
        $app->post('simulations/simulations_calculation', 'api\web\SimulationsController@post_simulations_calculation');
    });
});

// index
Route::get('/', 'web\WebTopController@get_top_index');

// aboutus
Route::get('aboutus', 'web\WebAboutusController@get_aboutus_index');
Route::get('aboutus/business', 'web\WebAboutusController@get_aboutus_business');
Route::get('aboutus/history', 'web\WebAboutusController@get_aboutus_history');
Route::get('aboutus/message', 'web\WebAboutusController@get_aboutus_message');
Route::get('aboutus/movie', 'web\WebAboutusController@get_aboutus_movie');
Route::get('aboutus/team', 'web\WebAboutusController@get_aboutus_team');

// contact
Route::get('contact', 'web\WebContactController@get_contact_index');
Route::get('contact/thanks', 'web\WebContactController@get_contact_thanks');

// customers
Route::get('customers', 'web\WebCustomersController@get_customers_index');
Route::get('customers/detail/{id}', 'web\WebCustomersController@get_customers_detail');

// downloadform
Route::get('downloadform/{id}', 'web\WebDownloadformController@get_downloadform_index');
Route::get('downloadform_thanks', 'web\WebDownloadformController@get_downloadform_thanks');

// downloads
Route::get('downloads', 'web\WebDownloadsController@get_downloads_index');

// management
Route::get('management', 'web\WebManagementController@get_management_index');

// order
Route::get('order', 'web\WebOrderController@get_order_index');

// privacy
Route::get('privacy', 'web\WebPrivacyController@get_privacy_index');

// products
Route::get('products', 'web\WebProductsController@get_products_index');

// seminar
Route::get('seminar', 'web\WebSeminarController@get_seminar_index');
Route::get('seminar/seminar_fix', 'web\WebSeminarController@get_seminar_fix');
Route::get('teacher/detail/{id}', 'web\WebSeminarController@get_teacher_detail');

// simulations
Route::get('simulations', 'web\WebSimulationsController@get_simulations_index');

// sitemap
Route::get('sitemap', 'web\WebSitemapController@get_sitemap_index');

// support
Route::get('support', 'web\WebSupportController@get_support_index');

// technology
Route::get('technology', 'web\WebTechnologyController@get_technology_index');

// topics
Route::get('topics', 'web\WebTopicsController@get_topics_index');
Route::get('topics/detail/{id}', 'web\WebTopicsController@get_topics_detail');

