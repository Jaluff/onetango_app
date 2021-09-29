<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use TiendaNube\Api as nubeApi;
use TiendaNube\Auth\Exception;

class ProductosController extends Controller
{
    public function getProductos()
    {
        if (session('store_id')) {
            $user_id = Auth::id();
            $store = User::find($user_id)->getStore;
            // $store = Store::where('tiendanube_id', $store_id)->first();
            //dd($store->tiendanube_id); 
            $api = new nubeApi($store->tiendanube_id, $store->access_token, 'TangoApi (ejlauff@grupod.ar)');
            try {
                $response = $api->get("products");
                $response_cat = $api->get("categories");
                $language = $response->main_language;
                // echo gettype($response);
                $produtcts  = $response->body;
                $prod_collection =  collect($produtcts);
                $tango_collection = collect($produtcts)
                ->map(function($produtcts) {
                    return $produtcts->variants->stock *2;
                });
            
                // var_dump($response_cat);
               dd($tango_collection);
                return view('productos.productos', [
                    'productos' => $prod_collection,
                    // 'categorias' => $response_cat->body,
                    'language' => $language
                ]);
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }
        } else {
            return Redirect::to('https://www.tiendanube.com/apps/3585/authorize');
        }
    }

    public function getProductosByCategoria(Request $request)
    {
    }
}
