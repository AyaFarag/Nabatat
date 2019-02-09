@extends("admin.layout.app")

@section("navbar")
  <h4>Users</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.user.index"),
    "placeholder" => "Search by name/email"
  ])
@stop

@section("content")
<div class="padded-container">
    <div class="card">
      <div class="card-content">
        @component("admin.components.form", [
          "method" => "get",
          "action" => route("admin.user.index"),
          "noCsrf" => true
        ])
          <div class="row">
            <div class="col-md-6 col-xs-6">
              @include("admin.components.input", [
                "label" => "Minimum Orders",
                "name" => "minimum_orders",
                "type" => "number",
                "old"  => request() -> input("minimum_orders")
              ])
            </div>
            <div class="col-md-6 col-xs-6">
              @include("admin.components.input", [
                "label" => "Maximum Orders",
                "name" => "maximum_orders",
                "type" => "number",
                "old"  => request() -> input("maximum_orders")
              ])
            </div>
            <div class="col-md-6 col-xs-6">
              @include("admin.components.input", [
                "label" => "Minimum Money Spent",
                "name" => "minimum_money_spent",
                "type" => "number",
                "old"  => request() -> input("minimum_money_spent")
              ])
            </div>
            <div class="col-md-6 col-xs-6">
              @include("admin.components.input", [
                "label" => "Maximum Money Spent",
                "name" => "maximum_money_spent",
                "type" => "number",
                "old"  => request() -> input("maximum_money_spent")
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
                "label" => "Start Registeration Date",
                "name" => "start_date",
                "type" => "date",
                "old"  => request() -> input("start_date")
              ])
            </div>
            <div class="col-md-4 col-xs-6">
              @include("admin.components.input", [
                "label" => "End Registeration Date",
                "name" => "end_date",
                "type" => "date",
                "old"  => request() -> input("end_date")
              ])
            </div>
          </div>
          <div class="flex justify-end margin-top">
            @include("admin.components.button", [ "label" => "Reset", "icon" => "replay", "class" => "reset-filters margin-right" ])
            <div class="multisubmit" data-action="{{ route("admin.user.index") }}">
              @include("admin.components.button", [
                "icon"  => "filter_list",
                "label" => "filter"
              ])
            </div>
          </div>
          <div class="multisubmit margin-top" data-action="{{ route("admin.user.report") }}">
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
          "baseRouteName" => "admin.user",
          "notFound"      => "No users were found!",
          "items"         => $users,
          "model"         => \App\Models\User::class,
          "columns"       => [
            "name"         => ["label" => "Name"],
            "email"        => ["label" => "Email"],
            "orders_count" => ["label" => "Orders Count"],
            "money_spent"  => ["label" => "Money Spent"]
          ],
          "actions" => [
            [
              "route"   => function ($item) { return route("admin.user.show", $item -> id); },
              "icon"    => "open_in_new",
              "tooltip" => "View"
            ]
          ]
        ])
      </div>
    </div>
  </div>
  @can("create", \App\Models\User::class)
    @include("admin.components.floating-fab", [
      "to"         => route("admin.user.create"),
      "tooltip"    => "New User",
      "attributes" => [
        "id" => "create-item"
      ]
    ])
    @include("admin.components.feature-discovery", [
      "target"  => "create-item",
      "title"   => "Create a new user",
      "color"   => "secondary",
      "content" => "You can click on this floating fab to create a new user.<br /> You'll only see this message once!"
    ])
  @endcan
@stop

@section("javascript")
<script>
$(".reset-filters").on("click", function (evt) {
  evt.preventDefault();
  window.location = "{{ route("admin.user.index") }}";
});
</script>
@stop