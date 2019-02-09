@extends("admin.layout.app")

@section("navbar")
  <h4>Orders</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.order.index"),
    "placeholder" => "Client name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content">
        @component("admin.components.form", [
          "method" => "get",
          "action" => route("admin.order.index"),
          "noCsrf" => true
        ])
          <h5>Status</h5>
          <div class="row margin-top margin-bottom">
            <div class="col-md-2 col-sm-3 col-xs-6">
              @include("admin.components.checkbox", [
                "label"   => "Pending",
                "name"    => "status[]",
                "value"   => \App\Models\Order::PENDING,
                "checked" => in_array(\App\Models\Order::PENDING, request() -> input("status") ?: [])
              ])
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6">
              @include("admin.components.checkbox", [
                "label"   => "Confirmed",
                "name"    => "status[]",
                "value"   => \App\Models\Order::CONFIRMED,
                "checked" => in_array(\App\Models\Order::CONFIRMED, request() -> input("status") ?: [])
              ])
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6">
              @include("admin.components.checkbox", [
                "label"   => "Preparing",
                "name"    => "status[]",
                "value"   => \App\Models\Order::PREPARING,
                "checked" => in_array(\App\Models\Order::PREPARING, request() -> input("status") ?: [])
              ])
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6">
              @include("admin.components.checkbox", [
                "label"   => "On The Way",
                "name"    => "status[]",
                "value"   => \App\Models\Order::ON_THE_WAY,
                "checked" => in_array(\App\Models\Order::ON_THE_WAY, request() -> input("status") ?: [])
              ])
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6">
              @include("admin.components.checkbox", [
                "label"   => "Returned",
                "name"    => "status[]",
                "value"   => \App\Models\Order::RETURNED,
                "checked" => in_array(\App\Models\Order::RETURNED, request() -> input("status") ?: [])
              ])
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6">
              @include("admin.components.checkbox", [
                "label"   => "Delivered",
                "name"    => "status[]",
                "value"   => \App\Models\Order::DELIVERED,
                "checked" => in_array(\App\Models\Order::DELIVERED, request() -> input("status") ?: [])
              ])
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-xs-6">
              @include("admin.components.input", [
                "label" => "Minimum Products",
                "name" => "minimum_products",
                "type" => "number",
                "old"  => request() -> input("minimum_products")
              ])
            </div>
            <div class="col-md-6 col-xs-6">
              @include("admin.components.input", [
                "label" => "Maximum Products",
                "name" => "maximum_products",
                "type" => "number",
                "old"  => request() -> input("maximum_products")
              ])
            </div>
            <div class="col-md-4 col-xs-12">
              @include("admin.components.select", [
                "label" => "City",
                "name" => "city_id",
                "options" => $cities,
                "old"  => request() -> input("city_id")
              ])
            </div>
            <div class="col-md-4 col-xs-6">
              @include("admin.components.input", [
                "label" => "Start Date",
                "name" => "start_date",
                "type" => "date",
                "old"  => request() -> input("start_date")
              ])
            </div>
            <div class="col-md-4 col-xs-6">
              @include("admin.components.input", [
                "label" => "End Date",
                "name" => "end_date",
                "type" => "date",
                "old"  => request() -> input("end_date")
              ])
            </div>
          </div>
          <div class="flex justify-end margin-top">
            @include("admin.components.button", [ "label" => "Reset", "icon" => "replay", "class" => "reset-filters margin-right" ])
            <div class="multisubmit" data-action="{{ route("admin.order.index") }}">
              @include("admin.components.button", [
                "icon"  => "filter_list",
                "label" => "filter"
              ])
            </div>
          </div>
          <div class="multisubmit margin-top" data-action="{{ route("admin.order.report") }}">
            @include("admin.components.button", [ "label" => "Generate Report", "color" => "secondary", "icon" => "subject" ])
          </div>
        @endcomponent
      </div>
    </div>
  </div>

  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [
          "notFound" => "No orders were found!",
          "items"    => $orders,
          "noEdit"   => true,
          "noDelete" => true,
          "model"    => \App\Models\Order::class,
          "columns"  => [
            "user_id"  => [
              "label" => "Client",
              "transform" => function($value, $order){
                return $order -> user -> name;
              }
            ],
            "total"  => [
              "label" => "Products",
              "transform" => function($value, $order){
                return $order -> products() -> count();
              }
            ],
            "status"  => [
              "label" => "Status",
              "transform" => function($value, $order){
                if ($order -> status == \App\Models\Order::PENDING)
                  return "<div class=\"badge pending\">PENDING</div>";
                elseif ($order -> status == \App\Models\Order::CONFIRMED)
                  return "<div class=\"badge confirmed\">CONFIRMED</div>";
                elseif ($order -> status == \App\Models\Order::ON_THE_WAY)
                  return "<div class=\"badge on-the-way\">ON THE WAY</div>";
                elseif ($order -> status == \App\Models\Order::PREPARING)
                  return "<div class=\"badge preparing\">PREPARING</div>";
                elseif ($order -> status == \App\Models\Order::RETURNED)
                  return "<div class=\"badge returned\">RETURNED</div>";
                elseif ($order -> status == \App\Models\Order::DELIVERED)
                  return "<div class=\"badge delivered\">DELIVERED</div>";
              }
            ],
            "delivery"  => [
              "label" => "Delivery Name",
              "transform" => function($value, $orders){
                return $orders->delivery['name'];
              }
            ],
          ],
          "actions" => [
            [
              "label"   => "view",
              "route"   => function ($order) { return route("admin.order.show", $order -> id); },
              "icon"    => "open_in_new",
              "tooltip" => "View"
            ],
            [
              "label"   => "view",
              "route"   => function ($order) { return route("admin.order.receipt", $order -> id); },
              "icon"    => "print",
              "tooltip" => "Receipt"
            ]
          ]
        ])
      </div>
    </div>
  </div>
@stop

@section("javascript")
<script>
$(".reset-filters").on("click", function (evt) {
  evt.preventDefault();
  window.location = "{{ route("admin.order.index") }}";
});
</script>
@stop