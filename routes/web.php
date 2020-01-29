<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'forum/travesti'],
function() {


    Route::get('', [
        'uses' => 'IndexController@index'])
        ->name('forum.index');

    Route::get('{state}/{city}/{slug}', [
        'uses' => 'IndexController@topicDetails'])
        ->name('forum.topic.details');

    Route::get('set-new-state/{id}', [
        'uses' => 'IndexController@setNewState'])
        ->name('set-new-state');

    Route::put('set-new-city', [
        'uses' => 'IndexController@setNewCity'])
        ->name('forum.set-new-city');


        Route::group(['middleware' => ['verified', 'auth']], function()
        {

            Route::get('{state}/{city}/topico/novo', [
                'uses' => 'IndexController@topicNew'])
                ->name('forum.topic.new');
            
            Route::post('topico/insert', [
                    'uses' => 'IndexController@topicInsert'])
                    ->name('forum.topic.insert');
            
            Route::post('topico/relato/novo', [
                'uses' => 'IndexController@commentInsert'])
                ->name('forum.topic.comment.insert');

        });
    

});










Auth::routes(['verify' => true]);


Route::group(['prefix' => 'forum/travesti/minha-conta', 
        'middleware' => ['verified', 'auth']],
    function() {

        Route::get('', [
            'uses' => 'MyAccountController@index'])
            ->name('forum.myaccount');

        Route::put('atualizar', [
            'uses' => 'MyAccountController@update'])
            ->name('forum.myaccount.update');
            
        Route::get('comentario/{id}/atualizar', [
            'uses' => 'MyAccountController@updateComment'])
            ->name('forum.myaccount.comment.update');
});
