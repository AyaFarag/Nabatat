@extends("admin.layout.app")

@section("navbar")
  <h4>Country</h4>
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content">
        @component("admin.components.form", [
          "method" => "post",
          "action" => route("admin.pages.store")
        ])
          @include("admin.pages.form")
          @include("admin.components.button", [
            "icon"  => "add",
            "label" => "create"
          ])
        @endcomponent
      </div>
    </div>
  </div>
@stop