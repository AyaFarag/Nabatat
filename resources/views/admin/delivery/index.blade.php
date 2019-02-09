@extends("admin.layout.app")

@section("navbar")
  <h4>Delivery</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.delivery.index"),
    "placeholder" => "Search by name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [
          "baseRouteName" => "admin.delivery",
          "notFound"      => "No delivery were found!",
          "items"         => $delivery,
          "model"         => \App\Models\Delivery::class,
          "columns"       => [
            "name"  => ["label" => "Delivery Name"],
            
          ]
        ])
      </div>
    </div>
  </div>
  @can("create", \App\Models\Delivery::class)
    @include("admin.components.floating-fab", [
      "to"         => route("admin.delivery.create"),
      "tooltip"    => "New Delivery",
      "attributes" => [
        "id" => "create-item"
      ]
    ])
    @include("admin.components.feature-discovery", [
      "target"  => "create-item",
      "title"   => "Create a new delivery",
      "color"   => "secondary",
      "content" => "You can click on this floating fab to create a new delivery.<br /> You'll only see this message once!"
    ])
  @endcan
@stop