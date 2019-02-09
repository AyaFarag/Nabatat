<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Product;

use App\Http\Resources\ProductSearchResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RateResource;

use DB;

class ProductController extends Controller
{
    private function applySorting($query, $sort) {
        $sortBy    = strtolower(ltrim($sort, "-")); // Sort by rating|time
        $sortDir   = "ASC"; // Sort direction ASC|DESC

        if (strpos($sort, "-") !== false)
            $sortDir = "DESC";

        switch ($sortBy) {
            case "rating":
                $query -> orderBy("average_rating", $sortDir);
                break;
            case "time":
                $query -> orderBy("products.created_at", $sortDir);
                break;
        }
    }

    public function search(Request $request, $type = "") {
        $products = Product::join("rates", "rates.product_id", "=", "products.id", "left outer")
            -> select([
                "rates.*",
                "products.*",
                DB::raw("AVG(rates.rate) as average_rating")
            ])
            -> groupBy("products.id");

        if (strtolower($type) === "offers") {
            $products -> whereHas("offer");
        }

        if ($request -> filled("category")) {
            $products -> where("category_id", $request -> input("category"));
        }

        if ($request -> filled("min_price")) {
            $products -> where("price", ">=", $request -> input("min_price"));
        }

        if ($request -> filled("max_price")) {
            $products -> where("price", "<=", $request -> input("max_price"));
        }

        if ($request -> filled("sort")) {
            $this -> applySorting($products, $request -> input("sort"));
        }

        return ProductResource::collection(
            $products -> paginate(12)
                -> appends($request -> query())
        );
    }

    public function bestSeller() {
        $products = Product::leftJoin("order_products", "products.id", "=", "order_products.product_id")
            -> selectRaw("products.*, count(order_id) as orders_count")
            -> groupBy("products.id")
            -> orderBy("orders_count", "DESC");
        return ProductResource::collection($products -> paginate(10));
    }

    public function show(Product $product) {
        return new ProductResource($product);
    }

    public function comments(Product $product) {
        $comments = $product -> ratings() -> where("status", 1) -> paginate();

        return RateResource::collection($comments);
    }
}
