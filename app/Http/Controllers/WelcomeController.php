<?php

namespace App\Http\Controllers;

use App\Visitor;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $ip = $request->ip();
        // dd($ip);
        $result = Visitor::where('visitor', $ip)->first();

        if (!$result) {

            $visitor = Visitor::create([
                'visitor' => $ip,
            ]);
        }

        $visitorCount = Visitor::all()->count();
        return view('welcome')->with(
            [
                'visitorCount' => $visitorCount
            ]
        );
    }
}
