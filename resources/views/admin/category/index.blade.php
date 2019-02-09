@extends("admin.layout.app")

@section("navbar")
  <h4>Category</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.category.index"),
    "placeholder" => "Search by name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [
          "baseRouteName" => "admin.category",
          "notFound"      => "No category were found!",
          "items"         => $category,
          "model"         => \App\Models\Category::class,
          "columns"       => [
            "name"      => ["label" => "Category Name"],
            "parent_id"  => [
              "label" => "Parent Category",
              "transform" => function($value, $category){
                return $category -> parent ? $category -> parent -> name : "--";
              }
            ]
          ]
        ])
      </div>
    </div>
  </div>
  @can("create", \App\Models\Category::class)
    @include("admin.components.floating-fab", [
      "to"         => route("admin.category.create"),
      "tooltip"    => "New category",
      "attributes" => [
        "id" => "create-item"
      ]
    ])
    @include("admin.components.feature-discovery", [
      "target"  => "create-item",
      "title"   => "Create a new category",
      "color"   => "secondary",
      "content" => "You can click on this floating fab to create a new category.<br /> You'll only see this message once!"
    ])
  @endcan
@stop