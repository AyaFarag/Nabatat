@extends("admin.layout.app")

@section("navbar")
  <h4>Offers</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.offer.index"),
    "placeholder" => "Search by name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [
          "baseRouteName" => "admin.offer",
          "notFound"      => "No offer were found!",
          "items"         => $offer,
          "model"         => \App\Models\Offer::class,
          "columns"       => [
            "product"  => [
              "label" => "Product",
              "transform" => function($value, $offer){
                return $offer->product->name;
              }
              ],
            "discount"  => [
              "label" => "Offer",
              "transform" => function ($value) {
                $value = $value * 100;
                return "$value%";
              }
            ],

          ]
        ])
      </div>
    </div>
  </div>
  @can("create", \App\Models\Offer::class)
    @include("admin.components.floating-fab", [
      "to"         => route("admin.offer.create"),
      "tooltip"    => "New offer",
      "attributes" => [
        "id" => "create-item"
      ]
    ])
    @include("admin.components.feature-discovery", [
      "target"  => "create-item",
      "title"   => "Create a new offer",
      "color"   => "secondary",
      "content" => "You can click on this floating fab to create a new offer.<br /> You'll only see this message once!"
    ])
  @endcan
@stop