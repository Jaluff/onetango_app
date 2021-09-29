<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use TiendaNube\Auth as nubeAuth;
use TiendaNube\Api as nubeApi;

class StoreController extends Controller
{
    public function tienda_login(Request $request)
    {
        $user_id = Auth::id();
        if($store = User::find($user_id)->getStore){
            
            session(['store_id' => $store->tiendanube_id]);
            session(['store_token' => $store->access_token]);
            return Redirect::to('/home');

        }elseif  (isset($request->code)) {

            $code = $request->code;
            $tiendanubeoauth = new nubeAuth(config('tnube.CLIENT_ID'), config('tnube.CLIENT_SECRET'));
            $request_token = $tiendanubeoauth->request_access_token($code);
            $store = new Store();
            $store->tiendanube_id = $request_token['store_id'];
            $store->user_id = Auth::id();
            $store->access_token = $request_token['access_token'];
            $store->save();
            return Redirect::to('/home');

        } else {

            return Redirect::to('https://www.tiendanube.com/apps/3585/authorize');

        }
    }

    // public function tiendaNube_callback()
    // {
    //     //echo session('store_id');
    //     if ($store_id = session('store_id')) {

    //         $store = Store::where('tiendanube_id', $store_id)->first();
    //         //dd($store->tiendanube_id);
    //         $api = new nubeApi($store->tiendanube_id, $store->access_token, 'TangoApi (ejlauff@grupod.ar)');
    //         $response = $api->get("products");
    //         $response_cat = $api->get("categories");

    //         return view('productos.productos', ['productos' => $response->body, 'categorias' => $response_cat->body]);

    //         // return response()->json(['response: ' => $response->body]);
    //     } else {
    //         return Redirect::to('https://www.tiendanube.com/apps/3585/authorize');
    //     }
    // }
}
