<?php

namespace App\Http\Controllers;
use App\Helpers;

use App\Models\Cat_product;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientHomeController extends Controller
{
    function home()
    {

        $featuredProducts = Product::where('featured', '1')->paginate(5);
        $bestsellingProducts = Product::where('bestselling', '1')->paginate(7);

        $list_cat_product = Cat_product::all();
        $result_cat = data_tree($list_cat_product);
        $menu = render_menu($result_cat, 'list-item', 'sub-menu');

        $list_cat_pr0 = Cat_product::where('parent_id', '0')->paginate(4);
        return view('client.home', compact('featuredProducts', 'bestsellingProducts', 'menu', 'list_cat_pr0'));

    }


}
