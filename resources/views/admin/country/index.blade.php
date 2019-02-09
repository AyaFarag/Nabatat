@extends("admin.layout.app")

@section("navbar")
  <h4>Country</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.country.index"),
    "placeholder" => "Search by name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [
          "baseRouteName" => "admin.country",
          "notFound"      => "No country were found!",
          "items"         => $country,
          "model"         => \App\Models\Country::class,
          "columns"       => [
            "name"  => ["label" => "Name"],
            
          ]
        ])
      </div>
    </div>
  </div>
  @can("create", \App\Models\Country::class)
    @include("admin.components.floating-fab", [
      "to"         => route("admin.country.create"),
      "tooltip"    => "New Country",
      "attributes" => [
        "id" => "create-item"
      ]
    ])
    @include("admin.components.feature-discovery", [
      "target"  => "create-item",
      "title"   => "Create a new country",
      "color"   => "secondary",
      "content" => "You can click on this floating fab to create a new country.<br /> You'll only see this message once!"
    ])
  @endcan
@stop