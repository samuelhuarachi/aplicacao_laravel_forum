<?php

namespace App\Http\Controllers\Chat;

use Session;
use Illuminate\Http\Request;
use App\Samuel\Chat\AnalistService;
use App\Http\Controllers\Controller;

class AnalistController extends Controller
{

    public function report(
        Request $request,
        AnalistService $analistService)
    {
        
        $token = Session::get('myToken');

        $_isValidToken = $analistService->_isTokenValid($token);
        
        if (!$_isValidToken) {
            abort(403, 'Unauthorized');
        }

        $myData = Session::get('myData');


        $year = $request->input('year');
        $mouth = $request->input('mounth');

        $report = null;
        if ($year && $mouth) {
            // get data of report
            
            $report = $analistService->getReportData($token, $year, $mouth);
        }
        
        return view('chat.analist.report', 
                    compact('myData', 'token', 'report'));
    }

     public function logout()
    {
        Session::forget('myData');
        return redirect()->route('analist.login');
    }


    
}