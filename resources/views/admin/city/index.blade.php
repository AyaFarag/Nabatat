@extends("admin.layout.app")

@section("navbar")
  <h4>Country</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.city.index"),
    "placeholder" => "Search by name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [
          "baseRouteName" => "admin.city",
          "notFound"      => "No city were found!",
          "items"         => $city,
          "model"         => \App\Models\City::class,
          "columns"       => [
            "name"  => ["label" => "City Name"],
            "country"  => [
              "label" => "Country",
              "transform" => function($value, $city){
                return $city->country->name;
              } 
              ],

          ]
        ])
      </div>
    </div>
  </div>
  @can("create", \App\Models\Country::class)
    @include("admin.components.floating-fab", [
      "to"         => route("admin.city.create"),
      "tooltip"    => "New city",
      "attributes" => [
        "id" => "create-item"
      ]
    ])
    @include("admin.components.feature-discovery", [
      "target"  => "create-item",
      "title"   => "Create a new city",
      "color"   => "secondary",
      "content" => "You can click on this floating fab to create a new city.<br /> You'll only see this message once!"
    ])
  @endcan
@stop