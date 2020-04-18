<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sandbox
    |--------------------------------------------------------------------------
    |
    | Checa se utilizará o Sandbox ou Production.
    |
    */
    'sandbox' => env('PAGSEGURO_SANDBOX', true),

    /*
    |--------------------------------------------------------------------------
    | Email
    |--------------------------------------------------------------------------
    |
    | Conta de email do Vendedor.
    |
    */
    'email' => env('PAGSEGURO_EMAIL', 'samuel.huarachi@gmail.com'),

    /*
    |--------------------------------------------------------------------------
    | Token
    |--------------------------------------------------------------------------
    |
    | Token do Vendedor.
    |
    */
    'token' => env('PAGSEGURO_TOKEN', '89A8090509134C359D43BAC938C4140A'),

    /*
    |--------------------------------------------------------------------------
    | NotificationURL
    |--------------------------------------------------------------------------
    |
    | URL de resposta para notificações do Pagseguro.
    |
    */
    'notificationURL' => env('PAGSEGURO_NOTIFICATION', 'http://localhost:3003/checkout/payments-methods/pagseguro'),

];
