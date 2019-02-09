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
      <div class="card-content">
        @component("admin.components.form", [
          "method" => "get",
          "noCsrf" => true,
          "action" => "#"
        ])
          <div class="row">
            <div class="col-md-4 col-xs-12">
              @include("admin.components.input", [
                "label" => "Minimum Price",
                "name" => "minimum_price",
                "type" => "number",
                "old"  => request() -> input("minimum_price")
              ])
            </div>

            <div class="col-md-4 col-xs-12">
              @include("admin.components.input", [
                "label" => "Maximum Price",
                "name" => "maximum_price",
                "type" => "number",
                "old"  => request() -> input("maximum_price")
              ])
            </div>
            <div class="col-md-4 col-xs-12">
              @include("admin.components.select", [
                "label" => "Category",
                "name" => "category_id",
                "options" => $categories,
                "old"  => request() -> input("category_id")
              ])
            </div>
            <div class="col-md-6 col-xs-12 row">
              <div class="col-xs-4">Has discount</div>
              <div class="col-xs-6">
                @include("admin.components.switch", [
                  "name"     => "has_discount",
                  "offLabel" => "no",
                  "onLabel"  => "yes",
                  "old"      => request() -> filled("has_discount")
                ])
              </div>
            </div>
            <div class="col-md-6 col-xs-12 row">
              <div class="col-xs-4">Out of stock</div>
              <div class="col-xs-6">
                @include("admin.components.switch", [
                  "name"     => "out_of_stock",
                  "offLabel" => "no",
                  "onLabel"  => "yes",
                  "old"      => request() -> filled("out_of_stock")
                ])
              </div>
            </div>
          </div>
          <div class="flex justify-end margin-top">
            @include("admin.components.button", [ "label" => "Reset", "icon" => "replay", "class" => "reset-filters margin-right" ])
            <div class="multisubmit" data-action="{{ route("admin.product.index") }}">
              @include("admin.components.button", [ "label" => "Search" ])
            </div>
          </div>
          <div class="multisubmit margin-top" data-action="{{ route("admin.product.report") }}">
            @include("admin.components.button", [ "label" => "Generate Report", "color" => "secondary", "icon" => "subject" ])
          </div>
        @endcomponent
      </div>
    </div>
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [
          "baseRouteName" => "admin.product",
          "notFound"      => "No products were found!",
          "items"         => $product,
          "model"         => \App\Models\Product::class,
          "columns"       => [
            "name"  => ["label" => "Name"],
            "category"  => [
              "label" => "Category",
              "transform" => function($value, $product){
                return $product->category->name;
              }
            ],
            "price" => ["label" => "Price"],
            "discounted_price" => ["label" => "Discounted price"]
          ]
        ])
      </div>
    </div>
  </div>
  @can("create", \App\Models\Product::class)
    @include("admin.components.floating-fab", [
      "to"         => route("admin.product.create"),
      "tooltip"    => "New Product",
      "attributes" => [
        "id" => "create-item"
      ]
    ])
    @include("admin.components.feature-discovery", [
      "target"  => "create-item",
      "title"   => "Create a new product",
      "color"   => "secondary",
      "content" => "You can click on this floating fab to create a new product.<br /> You'll only see this message once!"
    ])
  @endcan
@stop

@section("javascript")
<script>
$(".reset-filters").on("click", function (evt) {
  evt.preventDefault();
  window.location = "{{ route("admin.product.index") }}";
});
</script>
@stop