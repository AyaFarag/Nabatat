<?php

namespace App\Http\Controllers\Admin;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;

use App\Excel\ProductExcel;

use Session;

class ProductController extends Controller
{
    private function applyFilters(Request $request, $query) {
        if ($request -> filled("query"))
            $query -> search($request -> input("query"));
        if ($request -> filled("out_of_stock"))
            $query -> where("quantity", "=", 0);
        if ($request -> filled("has_discount"))
            $query -> hasOffer();
        if ($request -> filled("minimum_price"))
            $query -> where("price", "<=", $request -> input("minimum_price"));
        if ($request -> filled("maximum_price"))
            $query -> where("price", ">=", $request -> input("maximum_price"));
        if ($request -> filled("category_id"))
            $query -> where("category_id", $request -> input("category_id"));
    }

    public function index(Request $request)
    {
        $this -> authorize("view", Product::class);

        $categories = Category::pluck("name", "id") -> all();

        $product = Product::with("offer");
        $this -> applyFilters($request, $product);
        $product = $product -> paginate();
        return view('admin.product.index', compact('product', 'categories'));
    }

    public function report(Request $request) {
        $product = Product::query();
        $this -> applyFilters($request, $product);
        $totals = clone $product;
        $totals -> selectRaw("sum(order_products.quantity * order_products.price) as total, order_products.*, orders.status, orders.id, products.id")
            -> leftJoin("order_products", "order_products.product_id", "=", "products.id")
            -> leftJoin("orders", "orders.id", "=", "order_products.order_id")
            -> where("orders.status", Order::DELIVERED)
            -> groupBy("products.id");
        $report = new ProductExcel($product -> get(), $totals -> pluck("total", "id") -> all());
        return Excel::download($report, "products.xlsx");
    }

    public function create()
    {
        $this -> authorize("create", Product::class);

        $categories = Category::pluck("name", "id") -> all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $this -> authorize("create", Product::class);

        $product = Product::create($request->all());
        foreach ($request->file('images') as  $image) {
            $product->addMedia($image)->toMediaCollection('images');
        }
        Session::flash("success", "Product was added successfully!");

        return redirect() -> route("admin.product.index");
    }

    public function edit(Product $product)
    {
        $this -> authorize("update", Product::class);

        $categories = Category::pluck("name", "id") -> all();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {

        $this -> authorize("update", Product::class);

        $product-> fill($request -> all());
        foreach ($request->file('images') as  $image) {
            $product->addMedia($image)->toMediaCollection('images');
        }
        $product->save();
        Session::flash("success", "Product was updated successfully!");

        return redirect() -> route("admin.product.index");
    }

    public function destroy(Product $product)
    {
        $this -> authorize("delete", Product::class);

        $product->delete();
        Session::flash("success", "Product was deleted successfully!");

        return redirect() -> route("admin.product.index");
    }
}
