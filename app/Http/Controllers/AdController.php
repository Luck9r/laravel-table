<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Exception;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index()
    {
        try {
            $ads = Ad::orderBy('id')->get();
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "trace" => $e->getTraceAsString()
            ], 500);
        }
        return response()->json($ads);
    }

    public function show($id)
    {
        try {
            $ad = Ad::find($id);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "trace" => $e->getTraceAsString()
            ], 500);
        }
        if (empty($ad)) {
            return response()->json([
                "message" => "Could not find an ad with this id!"
            ], 404);
        }
        return response()->json($ad);
    }

    public function paginate(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('perPage', 20);
        $page = $request->query('page');

        if ($search) {
            // The query builder uses parameter binding so this should be safe from SQL injections
            $page = Ad::where('id', 'LIKE', $search . '%')
                ->orderBy('id')
                ->paginate($perPage, ['*'], 'page', $page);
        } else {
            $page = Ad::orderBy('id')
                ->paginate($perPage, ['*'], 'page', $page);
        }
        return response()->json($page);

    }
}
