<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $locations = DB::table('stores')->orderBy('id','desc')->get();
        return view('googlemap')->with(compact('locations'));
    }

    public function nearByStores(Request $request)
    {
        $sqlDistance = DB::raw('( 6371 * acos( cos( radians(' . $request->pos['lat'] . ') ) *
                            cos( radians(stores.latitude) ) *
                            cos( radians(stores.longitude) - radians(' . $request->pos['lng'] . ') ) + 
                            sin( radians(' . $request->pos['lat'] . ') ) *
                            sin( radians(stores.latitude) ) ) )');                    

        $stores =  DB::table('stores')
            ->select(
                'stores.latitude',
                'stores.longitude',
                'stores.*'
            )
            ->selectRaw("{$sqlDistance} AS distance")
            ->orderBy('distance')
            ->get();

        return json_encode($stores, true);
    }
}
