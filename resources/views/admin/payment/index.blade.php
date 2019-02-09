@extends("admin.layout.app")

@section("navbar")
  <h4>Products</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.product.index"),
    "placeholder" => "Search by name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [
          "baseRouteName" => "admin.payment",
          "notFound"      => "No payment methods were found!",
          "noDelete"      => true,
          "items"         => $payment_methods,
          "model"         => \App\Models\Payment::class,
          "columns"       => [
            "title" => ["label" => "Name"],
            "status" => [
              "label" => "Status",
              "transform" => function ($status, $payment) {
                return $status == 1 ? "<div class=\"badge green\">Active</div>" : "<div class=\"badge red\">Inactive</div>";
              }
            ]
          ]
        ])
      </div>
    </div>
  </div>
@stop