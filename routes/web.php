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

Route::get('forum/travesti', [
    'uses' => 'IndexController@index'])
    ->name('forum.index');

Route::put('forum/travesti/set-new-city', [
    'uses' => 'IndexController@setNewCity'])
    ->name('forum.set-new-city');

// fazendo essa rota
Route::get('forum/travesti/{state}/{city}/{slug}', [
        'uses' => 'IndexController@topicDetails'])
        ->name('forum.topic.details');

Route::get('forum/travesti/{state}/{city}/topico/novo', [
    'uses' => 'IndexController@topicNew'])
    ->name('forum.topic.new')
    ->middleware(['auth']);

Route::post('forum/travesti/topico/insert', [
        'uses' => 'IndexController@topicInsert'])
        ->name('forum.topic.insert')
        ->middleware(['auth']);

Route::post('forum/travesti/topico/relato/novo', [
    'uses' => 'IndexController@commentInsert'])
    ->name('forum.topic.comment.insert')
    ->middleware(['auth']);
    
Route::get('forum/travesti/set-new-state/{id}', [
    'uses' => 'IndexController@setNewState'])
    ->name('set-new-state');

Auth::routes(['register'=>false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'forum/travesti/minha-conta', 'middleware' => ['auth']],
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
