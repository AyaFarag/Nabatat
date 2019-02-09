@extends("admin.layout.app")

@section("navbar")
  <h4>Requests</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.request.index"),
    "placeholder" => "Search by name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        @include("admin.components.crud-table", [
          "baseRouteName" => "admin.request",
          "notFound"      => "No requests were found!",
          "items"         => $requests,
          "model"         => \App\Models\ServiceRequest::class,
          "noEdit"        => true,
          "actions" => [
            [
              "label"   => "view",
              "route"   => function ($request) { return route("admin.request.show", $request -> id); },
              "icon"    => "open_in_new",
              "tooltip" => "View",
              "visible" => auth() -> user() -> can("view", \App\Models\ServiceRequest::class)
            ]
          ],
          "columns"       => [
            "user_id"  => [
              "label" => "Name",
              "transform" => function ($val, $request) {
                return $request -> user -> name;
              }
            ],
            "size"  => ["label" => "Size"],
            "address"  => ["label" => "Address"],
            "status"  => [
              "label" => "Status",
              "transform" => function($value, $request){
                if (is_null($request -> approved_at))
                  return "<div class=\"badge pending\">PENDING</div>";
                else
                  return "<div class=\"badge delivered\">APPROVED</div>";
              }
            ],
          ]
        ])
      </div>
    </div>
  </div>
@stop