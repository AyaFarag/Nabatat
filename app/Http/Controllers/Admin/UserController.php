<?php

namespace App\Http\Controllers\Admin;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\UserRequest;

use App\Models\User;
use App\Models\UserPhone;
use App\Models\City;
use App\Models\Order;

use App\Excel\UserExcel;

use Session;

class UserController extends Controller
{
    private function applyFiltering(Request $request, $query) {
        $query -> withMoneySpent();

        if ($request -> filled("query"))
            $query -> search($request -> input("query"));
        if ($request -> filled("minimum_orders"))
            $query -> has("orders", ">=", $request -> input("minimum_orders"));
        if ($request -> filled("maximum_orders"))
            $query -> has("orders", "<=", $request -> input("maximum_orders"));
        if ($request -> filled("minimum_money_spent"))
            $query -> having("money_spent", ">=", $request -> input("minimum_money_spent"));
        if ($request -> filled("maximum_money_spent"))
            $query -> having("money_spent", "<=", $request -> input("maximum_money_spent"));
        if ($request -> filled("start_date"))
            $query -> where("users.created_at", ">=", $request -> input("start_date"));
        if ($request -> filled("end_date"))
            $query -> where("users.created_at", "<=", $request -> input("end_date"));
        if ($request -> filled("city_id")) {
            $query -> whereHas("addresses", function ($query) use ($request) {
                return $query -> where("city_id", "=", $request -> input("city_id"));
            });
        }
        if ($request -> filled("minimum_money_spent") || $request -> filled("maximum_money_spent"))
            $query -> whereNotNull("payment_date");
    }

    public function index(Request $request)
    {
        $this -> authorize("view", User::class);

        $users = User::withTrashed()
            -> with("ordersCount");

        $this -> applyFiltering($request, $users);
        $users = $users -> orderBy("users.created_at", "DESC") -> simplePaginate();
        $cities = City::pluck("name", "id") -> all();
        return view("admin.user.index", compact("users", "cities"));
    }

    public function report(Request $request)
    {
        $users = User::withTrashed()
            -> with("ordersCount", "phones", "addresses.city");

        $this -> applyFiltering($request, $users);

        $report = new UserExcel($users -> get());
        return Excel::download($report, "users.xlsx", \Maatwebsite\Excel\Excel::XLSX);
    }

    public function show($id)
    {
        $this -> authorize("view", User::class);

        $user = User::with("addresses", "orders", "requests") -> findOrFail($id);

        $money_spent = User::withMoneySpent()
            -> where("users.id", $user -> id)
            -> first()
            -> money_spent;

        return view("admin.user.show", compact("user", "money_spent"));
    }

    public function create()
    {
        $this -> authorize("create", User::class);

        $cities = City::pluck("name", "id") -> all();

        return view("admin.user.create", compact("cities"));
    }

    public function store(UserRequest $request)
    {
        $this -> authorize("create", User::class);


        $user = new User();
        $user -> fill($request -> all());
        $user -> activated = $request -> filled("activated");
        $user -> save();

        if ($request -> filled("phones")) {
            UserPhone::unguard(); // to allow mass assignment on the confirmed column
            $user -> phones() -> createMany(array_map(function ($phone) {
                $confirmed = true;
                return compact("phone", "confirmed");
            }, $request -> input("phones")));
            UserPhone::reguard();
        }
        if ($request -> filled("addresses")) {
            $user -> addresses() -> createMany($request -> input("addresses"));
        }
        Session::flash("success", "User was added successfully!");

        return redirect() -> route("admin.user.index");
    }

    public function edit(User $user)
    {
        $this -> authorize("update", User::class);

        $cities = City::pluck("name", "id") -> all();

        return view("admin.user.edit", compact("user", "cities"));
    }

    public function update(UserRequest $request, User $user)
    {
        $this -> authorize("update", User::class);

        $user -> fill($request -> all());
        $user -> activated = $request -> filled("activated");
        if ($request -> filled("password"))
            $user -> password = $request -> input("password");
        if ($request -> filled("phones")) {
            $user -> phones() -> delete();
            $user -> phones() -> createMany(array_map(function ($phone) {
                $confirmed = true;
                return compact("phone", "confirmed");
            }, $request -> input("phones")));
        }
        if ($request -> filled("addresses")) {
            $user -> addresses() -> delete();
            $user -> addresses() -> createMany($request -> input("addresses"));
        }

        $user -> save();

        Session::flash("success", "User was updated successfully!");

        return redirect() -> route("admin.user.edit", $user -> id);
    }

    public function destroy(User $user)
    {
        $this -> authorize("delete", User::class);

        $user -> delete();

        Session::flash("success", "User was deleted successfully!");

        return redirect() -> route("admin.user.index");
    }
}
