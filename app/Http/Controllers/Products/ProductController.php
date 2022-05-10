<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyAdvertising;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductsInCategories;
use Illuminate\Http\Request;
use App\Enums\DiscountType;
use ATehnix\VkClient\Auth;
use ATehnix\VkClient\Client;
use Illuminate\Http\Response;

class ProductController extends Controller
{


    public function getUserToken($id)
    {
        session(['company' => $id]);
        $result['href'] = 'https://oauth.vk.com/authorize?client_id=7883909&scope=market&redirect_uri=https://your-cashman.com/upload-products&response_type=code&display=page';
        return response()->json($result);

    }

    public function uploadProducts(Request $request)
    {
        if (!session()->has('company')) {
            return redirect()->route('profile');
        }
        $auth = new Auth('7883909', 'B95nspocgcljhxTATjTN', 'https://your-cashman.com/upload-products', 'market, groups');
        $id = session('company');
        $company = Company::find($id);
        $group = $company->upload_vk_url;
        $number = strrchr($group, '/');
        $name = mb_substr($number, 1);
        $token = null;

        if ($request->has("code")) {
            $token = $auth->getToken($request->get('code'));
            $api = new Client('5.131');
            $api->setDefaultToken($token);
            $response = $api->request('groups.getById', [
                'group_id' => $name,
            ]);
            $group_id = $response['response'][0]['id'];
            $response1 = $api->request('market.getAlbums', [
                'owner_id' => -$group_id,
                'count' => 50
            ]);
            foreach ($response1["response"]["items"] as $item) {
                $response2 = $api->request('market.get', [
                    'owner_id' => -$group_id,
                    'album_id' => $item["id"],
                    'count' => 200,
                ]);
                foreach ($response2["response"]["items"] as $item2) {
                    preg_match_all('/(#\w+)/u', $item2["description"], $matches);
                    $cat = count($matches[0]) > 0 ? $matches[0][0] : "#безкатегории";
                    $category = ProductCategory::where("title", $cat)->first();
                    if (is_null($category)) {
                        $category = ProductCategory::create([
                            "title" => $cat
                        ]);
                    }
                    $price = intval($item2["price"]["amount"]) / 100;//$matches[0][0] ?? 0;
                    $tmp_old_price = isset($item2["price"]["old_amount"]) ? intval($item2["price"]["old_amount"]) / 100 : 0;
                    $description = $item2["description"];
                    $food_status = [
                        "Акция!" => DiscountType::Promotion,
                        "Скидка!" => DiscountType::Promotion,
                        "Топ!" => DiscountType::InTheTop,
                        "Хит продаж!" => DiscountType::BestSeller,
                        "Новинка!" => DiscountType::NewFood,
                        "На вес!" => DiscountType::WeightFood,
                    ];
                    $food_status_index = null;

                    foreach ($food_status as $key => $status)
                        if (mb_strpos(mb_strtolower($description), mb_strtolower($key)))
                            $food_status_index = $key;
                    if (is_null(Product::where(['title' => $item2['title'], 'company_id' => $company->id, 'description' => $description, 'discount_price' => $tmp_old_price])->first())) {
                        $product = Product::create([
                            'company_id' => $company->id,
                            'title' => $item2["title"],
                            'description' => $description,
                            'price' => $price,
                            'discount_price' => $tmp_old_price,
                            'type' => is_null($food_status_index) ? DiscountType::Unset : $food_status[$food_status_index],
                            'image' => $item2["thumb_photo"],

                        ]);

                        if (is_null($product->categories()->find($category->id)))
                            ProductsInCategories::create([
                                'product_category_id' => $category->id,
                                'product_id' => $product->id
                            ]);
                    }
                }
                sleep(1);
            }
        }
        return redirect()->route('companyProducts', ['id' => $id]);
    }

    public function getProducts($id)
    {
        return response()->json([
            'products' => Product::where('company_id', $id)->get(),
            'company'=>Company::find($id)
        ], Response::HTTP_OK);

    }

    public function getProductsAndCategories()
    {
        return response()->json([
            'products' => Product::latest()->get(),
            'categories' => ProductCategory::latest()->get(),
            'stories' => CompanyAdvertising::where('type', 'Сторис')->get()
        ], Response::HTTP_OK);
    }

    public function getProductsByCategory($id)
    {
        $category = ProductCategory::find($id);
        $products = $category->products()->get();
        return response()->json([
            'products' => $products
        ], Response::HTTP_OK);

    }

    public function getProductPage($id){
        $product = Product::find($id);
        $company = Company::find($product->company_id);
        $comments = [];
        return view('pages.products.productDetailsPage', compact('product', 'company', 'comments'));
    }
}
