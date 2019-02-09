@extends("admin.layout.app")

@section("navbar")
  <h4>Service</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.service.index"),
    "placeholder" => "Search by name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [
          "baseRouteName" => "admin.service",
          "notFound"      => "No service were found!",
          "items"         => $services,
          "model"         => \App\Models\Service::class,
          "columns"       => [
            "title"  => ["label" => "Service Title"],
            "parent"  => [
              "label" => "Parent",
              "transform" => function($value, $services){
                return '';
              } 
              ],

          ]
        ])
      </div>
    </div>
  </div>
  @can("create", \App\Models\Service::class)
    @include("admin.components.floating-fab", [
      "to"         => route("admin.service.create"),
      "tooltip"    => "New service",
      "attributes" => [
        "id" => "create-item"
      ]
    ])
    @include("admin.components.feature-discovery", [
      "target"  => "create-item",
      "title"   => "Create a new service",
      "color"   => "secondary",
      "content" => "You can click on this floating fab to create a new service.<br /> You'll only see this message once!"
    ])
  @endcan
@stop