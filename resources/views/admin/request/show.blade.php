@extends("admin.layout.app")

@section("navbar")
  <h4 class="hide-on-small-only">Requests</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.order.index"),
    "placeholder" => "Client name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content">
        <div>
          <h2>General Info</h2>
          <div class="vertical-margin">
            <div>
              <h5>Client</h5>
              <div class="flex margin-top align-center">
                <i class="material-icons margin-right">person</i>
                <span class="washed-out">Name : </span>
                <strong class="horizontal-margin" style="font-size : 20px">{{ $request -> user -> name }}</strong>
              </div>
              <div class="flex margin-top align-center">
                <i class="material-icons margin-right">location_city</i>
                <span class="washed-out">Email : </span>
                <strong class="horizontal-margin" style="font-size : 20px">{{ $request -> user -> email }}</strong>
              </div>
            </div>
            <div class="margin-top">
              <h5>Size</h5>
              <div class="flex margin-top align-center">
                <i class="material-icons margin-right">landscape</i>
                <span class="washed-out">Size : </span>
                <strong class="horizontal-margin" style="font-size : 20px">{{ $request -> size }}</strong>
              </div>
              <div class="flex margin-top align-center">
                <i class="material-icons margin-right">location_city</i>
                <span class="washed-out">Address : </span>
                <strong class="horizontal-margin" style="font-size : 20px">{{ $request -> address }}</strong>
              </div>
            </div>
          </div>
        </div>
        <div class="margin-top">
          <h4>Actions</h4>
          <div class="actions margin-top row">
            @if (is_null($request -> approved_at) && auth() -> user() -> can("update", \App\Models\ServiceRequest::class))
              @component("admin.components.form", [
                "method" => "post",
                "action" => route("admin.request.approve", ["request" => $request -> id])
              ])
                @include("admin.components.button", [
                  "icon"     => "check",
                  "label"    => "approve",
                  "position" => "justify-start",
                  "color"    => "secondary",
                  "class"    => "margin-right"
                ])
              @endcomponent
            @endif
            @if (auth() -> user() -> can("delete", \App\Models\ServiceRequest::class))
              @component("admin.components.form", [
                "class"  => "delete-form",
                "method" => "DELETE",
                "action" => route("admin.request.destroy", ["request" => $request -> id])
              ])
                @include("admin.components.button", [
                  "icon"     => "delete",
                  "label"    => "delete",
                  "position" => "justify-start",
                  "color"    => "secondary",
                  "attributes" => [
                    "style" => "background-color : red!important"
                  ]
                ])
              @endcomponent
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="padded-container">
    <div class="card">
      <div class="card-content">
        <h2>Location</h2>
        <div class="vertical-margin" id="map" style="width : 100; height : 450px">
        </div>
      </div>
    </div>
  </div>
  <div class="padded-container">
    <div class="card">
      <div class="card-content">
        <h2>Images</h2>
        <div class="vertical-margin row">
          @foreach ($request -> images as $image)
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
              <a href="{{ $image }}" target="_blank">
                <img class="responsive-img" src="{{ $image }}" />
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@stop

@section("javascript")
<script>
  function initMap() {
    console.log("hhere");
    var position = { lat: {{ $request -> lat }}, lng: {{ $request -> lang }} };
    var map = new google.maps.Map(document.getElementById("map"), { zoom: 17, center: position });
    var marker = new google.maps.Marker({ position, map });
  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env("GMAPS_API_KEY") }}&callback=initMap"></script>
@stop