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

// Route::get('tools/folders', [
//     'uses' => 'ToolsController@createS3FoldersOfGirls']);

// Route::get('tools/extract-images', [
//     'uses' => 'ToolsController@extractImagesFromWebSite']);

// Route::get('tools/full-scan', [
//     'uses' => 'ToolsController@fullScan']);



// Route::get('tools/get-city-and-state-topics-available', [
//     'uses' => 'ToolsController@getCityAvailable']);

// Route::get('tools/routine-scan', [
//     'uses' => 'ToolsController@routineScan']);

// Route::get('tools/fill-photos', [
//     'uses' => 'ToolsController@fillPhotos']);

// Route::get('sitemap/generate', [
//     'uses' => 'SitemapController@generate']);

Route::group(['prefix' => 'forum/travesti'],
function() {


    // Route::get('teste2', [
    //     'uses' => 'IndexController@teste2'])
    //     ->name('forum.teste2');

    // Route::get('teste3', [
    //    'uses' => 'IndexController@teste3'])
    //    ->name('forum.teste3');

    
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

            Route::post('reply/new', [
                'uses' => 'IndexController@newReply'])
                ->name('forum.reply.new');
        });
    
    Route::group(['prefix' => 'minha-conta', 
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

            Route::put('comentario/atualizar', [
                'uses' => 'MyAccountController@updateCommentRequest'])
                ->name('forum.myaccount.comment.update.request');

            Route::get('reply/{id}/edit', [
                'uses' => 'MyAccountController@editReply'])
                ->name('forum.reply.edit');

            Route::put('reply/update', [
                'uses' => 'MyAccountController@updateReply'])
                ->name('forum.reply.update');

            Route::get('comment/{id}/remove', [
                'uses' => 'MyAccountController@commentRemove'])
                ->name('forum.comment.remove');

            Route::get('reply/{id}/remove', [
                'uses' => 'MyAccountController@replyRemove'])
                ->name('forum.reply.remove');
    });


    Route::get('{cellphone?}', [
        'uses' => 'IndexController@index'])
        ->name('forum.index');
});


Route::group(['prefix' => 'camstream'],
function() {

    /**
     * Analist
     */

    Route::group(['prefix' => 'analist'],
    function() {
        Route::get('login', 'Chat\ChatController@analistLogin')->name('analist.login');

        Route::post('authenticate', 'Chat\ChatController@authenticate')
                        ->name('chat.analist.authenticate');
        
        Route::get('logout', 'Chat\AnalistController@logout')
            ->name('chat.analist.logout');

        Route::get('relatorio-de-ganhos', 'Chat\AnalistController@report')
            ->name('chat.analist.report');

        Route::get('{slug}', 'Chat\ChatController@analist')
                        ->name('chat.analist');

    
    });
    
    


    /**
     * client
     */


    Route::get('termos-de-uso', function () {
        return view('chat.termos_de_uso');
    })->name('chat.termos_de_uso');

    Route::get('politica-de-privacidade', function () {
        return view('chat.politica_de_privacidade');
    })->name('chat.politica_de_privacidade');

    Route::get('politica-de-cookies', function () {
        return view('chat.politica_de_cookies');
    })->name('chat.politica_de_cookies');
    


    Route::get('', 'Chat\ChatController@chat')
                            ->name('chat');

    Route::get('garota/auth/{token}', 'Chat\ClientController@authClient')
        ->name('chat.client.auth.token');

    Route::get('garota/email_verified/{nickname}/{email_token}', 'Chat\ClientController@emailVerified')
        ->name('chat.client.email_verified');

    Route::get('garota/forgot_email/{nickname}/{token}', 
                    'Chat\ClientController@forgotEmail')
        ->name('chat.client.forgot_email');

    Route::get('garota/resend-verified-mail/{token}', 
                    'Chat\ClientController@resendVerifiedMail')
        ->name('chat.client.resend-verified-mail');

    Route::get('garota/logout', 'Chat\ClientController@logout')
        ->name('chat.client.logout');

    Route::post('garota/payment', 'Chat\ClientController@payment')
        ->name('chat.client.payment');

    Route::get('garota/transactions', 'Chat\ClientController@transactions')
        ->name('chat.client.transactions');

    Route::get('garota/{slug}', 'Chat\ChatController@client')
            ->name('chat.client');
});


Auth::routes(['verify' => true]);
