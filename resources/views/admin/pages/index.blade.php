@extends("admin.layout.app")

@section("navbar")
  <h4>Pages</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.pages.index"),
    "placeholder" => "Search by name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [ 
          "baseRouteName" => "admin.pages",
          "notFound"      => "No Page were found!",
          "items"         => $page,
          "model"         => \App\Models\Page::class,
          "noDelete"      => false,
          "columns"       => [
            "title"  => ["label" => "Page Name"],
          ]
        ])
      </div>
    </div>
  </div>
@stop