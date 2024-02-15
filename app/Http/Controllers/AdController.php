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
            $ads = Ad::orderBy('impressions', 'desc')->get();
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
            $ad = Ad::firstWhere('ad_id', '=', $id);
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
        $perPage = $request->query('perPage', 15);
        $page = $request->query('page');

        if ($search) {
            // The query builder uses parameter binding so this should be safe from SQL injections
            $page = Ad::where('ad_id', 'LIKE', $search . '%')
                ->orderBy('impressions', 'desc')
                ->paginate($perPage, ['ad_id', 'impressions', 'clicks', 'unique_clicks', 'leads', 'conversion', 'roi'], 'page', $page)
                ->withPath('/api/ads/paginate?search=' . $search);
        } else {
            $page = Ad::orderBy('impressions', 'desc')
                ->paginate($perPage, ['ad_id', 'impressions', 'clicks', 'unique_clicks', 'leads', 'conversion', 'roi'], 'page', $page);
        }
        return response()->json($page);

    }
}
