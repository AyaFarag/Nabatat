@extends("admin.layout.app")

@section("navbar")
  <h4>Products</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.order.index"),
    "placeholder" => "Client name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [
          "notFound"      => "No orders were found!",
          "items"         => $orders,
          "model"         => \App\Models\Product::class,
          "columns"       => [
            "category"  => [
              "label" => "Client",
              "transform" => function($value, $order){
                return $order -> user -> name;
              }
            ],
          ]
        ])
      </div>
    </div>
  </div>
@stop