<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $result = DB::select("SELECT c.name, english_name, alphabetic_code, digit_code, r.value FROM currencies c LEFT JOIN (SELECT MAX(id) max_id, currency_id FROM rate GROUP BY currency_id)
                                    c_max ON c_max.currency_id = c.id LEFT JOIN rate r ON (r.id = c_max.max_id)");

        return response()->json($result, 200);
    }

    public function show(Request $request, $id)
    {
        $result = DB::select("SELECT c.name, english_name, alphabetic_code, digit_code, r.value FROM currencies c LEFT JOIN (SELECT MAX(id) max_id, currency_id FROM rate GROUP BY currency_id)
                                    c_max ON c_max.currency_id = c.id LEFT JOIN rate r ON (r.id = c_max.max_id) WHERE c.id = $id");

        return response()->json($result, 200);
    }
}
