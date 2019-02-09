@extends("admin.layout.app")

@section("navbar")
  <h4>Products Rates</h4>
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
          "noEdit"      => true,
          "noDelete"      => true,
          "baseRouteName" => "admin.rate",
          "notFound"      => "No rate were found!",
          "items"         => $rate,
          "model"         => \App\Models\Rate::class,
          "columns"       => [
            "rate"  => ["label" => "Rate"],
            "comment"  => ["label" => "Comment"],
            "product"  => [
              "label" => "Product Name",
              "transform" => function($value, $rate){
                return $rate->product->name;
              }
            ],
            
          ],

           "actions"  => [
            [
            "label" => "Approve",
            "route" => function ($rate) { return route("admin.rate.approve", $rate->id ); },
            "icon" => "check",
            "tooltip" => "Approve"
            ],
             
            [
            "label" => "Reject",
            "route" => function ($rate) { return route("admin.rate.reject", $rate->id ); },
            "icon" => "clear",
            "tooltip" => "Reject"
            ]
          ], 
        ])

      </div>
    </div>
  </div>
  @can("create", \App\Models\Rate::class)
    @include("admin.components.feature-discovery", [
      "target"  => "create-item",
      "title"   => "Create a new product",
      "color"   => "secondary",
      "content" => "You can click on this floating fab to create a new product.<br /> You'll only see this message once!"
    ])
  @endcan
@stop