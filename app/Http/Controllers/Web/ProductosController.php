<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use TiendaNube\Api as nubeApi;

class ProductosController extends Controller
{
    public function getProductos()
    {
        if ($store_id = session('store_id')) {
            $store = Store::where('tiendanube_id', $store_id)->first();
            //dd($store->tiendanube_id);
            $api = new nubeApi($store->tiendanube_id, $store->access_token, 'TangoApi (ejlauff@grupod.ar)');
            $response = $api->get("products");
            $response_cat = $api->get("categories");
            
            $language = $response->main_language;
            $prod_collection =  collect($response->body);
            dd($prod_collection);
            return view('productos.productos', [
                'productos' => $prod_collection, 
                'categorias' => $response_cat->body, 
                'language' => $language]);
            // return response()->json(['response: ' => $response->body]);
        } else {
            return Redirect::to('https://www.tiendanube.com/apps/3585/authorize');
        }
    }
}
