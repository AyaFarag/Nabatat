<div class="product-card row" style="padding : 20px 10px;">
  <div class="col-sm-2">
    <img class="responsive-img" src="{!! $product -> media -> first() ? $product -> media -> first() -> getUrl() : "unknown" !!}" />
  </div>
  <div class="col-sm-10 horizontal-padding small">
    <h6 class="center-align"><strong>{{ $product -> name }}</strong></h6>
    <div class="row end-md">
      <div class="col-lg-9 col-md-7 left-align">
        <p class="washed-out">{{ $product -> description }}</p>
        <div>
          <div>
            <strong>Price : {{ $product -> pivot -> price }}</strong>
          </div>
          <div>
            <strong>Total : {{ $product -> pivot -> price * $product -> pivot -> quantity }}</strong>
          </div>
        </div>
      </div>
      @component("admin.components.form", [
        "method" => "put",
        "action" => route("admin.order.product.modify", ["order" => $order -> id, "product" => $product -> id]),
        "class" => "col-lg-3 col-md-5"
      ])
        <div class="flex align-center">
          <div style="margin-right : 20px">
            @include("admin.components.input", [
              "name" => "quantity",
              "label" => "Quantity",
              "type" => "number",
              "old"  => $product -> pivot -> quantity,
              "attributes" => [
                "style" => "margin : 0; width : 70px;"
              ]
            ])
          </div>
          @include("admin.components.button", [
            "icon"     => "replay",
            "label"    => "change",
            "position" => "justify-center",
            "color"    => "secondary",
            "disabled" => !(isset($editable) && $editable)
          ])
        </div>
      @endcomponent
    </div>
  </div>
</div>