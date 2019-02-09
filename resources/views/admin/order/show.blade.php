@extends("admin.layout.app")

@section("navbar")
  <h4 class="hide-on-small-only">Orders</h4>
  @include("admin.components.navbar-search", [
    "route"       => route("admin.order.index"),
    "placeholder" => "Client name"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content no-padding">
        <div class="row">
          <div class="col-xs-12" style="padding : 0">
            <ul class="tabs">
              <li class="tab col s3"><a class="active" href="#info">Info</a></li>
              <li class="tab col s3"><a href="#products">Products</a></li>
              <li class="tab col s3"><a href="#delivery">Delivery</a></li>
              <li class="tab col s3"><a href="#status">Status</a></li>
            </ul>
          </div>

          {{-- info --}}
          <div id="info" class="col-xs-12">
            <div class="padded-container">
              <h5 class="flex space-between">
                <strong>Order #{{ $order -> id }}</strong>
                @if ($order -> status == \App\Models\Order::PENDING)
                  <div class="badge pending">PENDING</div>
                @elseif ($order -> status == \App\Models\Order::CONFIRMED)
                  <div class="badge confirmed">CONFIRMED</div>
                @elseif ($order -> status == \App\Models\Order::ON_THE_WAY)
                  <div class="badge on-the-way">ON THE WAY</div>
                @elseif ($order -> status == \App\Models\Order::PREPARING)
                  <div class="badge preparing">PREPARING</div>
                @elseif ($order -> status == \App\Models\Order::RETURNED)
                  <div class="badge returned">RETURNED</div>
                @elseif ($order -> status == \App\Models\Order::DELIVERED)
                  <div class="badge delivered">DELIVERED</div>
                @endif
              </h5>
              <div class="margin-top">
                <div>Name : <span class="washed-out">{{ $order -> user -> name }}</span></div>
                <div>Email : <span class="washed-out">{{ $order -> user -> email }}</span></div>

                <div>Country : <span class="washed-out">{{ $order -> address -> city -> country -> name }}</span></div>
                <div>City : <span class="washed-out">{{ $order -> address -> city -> name }}</span></div>
                <div>Address : <span class="washed-out">{{ $order -> address -> address }}</span></div>
                <div>Payment Methods :
                  <ul>
                    @foreach ($order -> paymentDetailes as $payment)
                      <li>
                        <span class="washed-out">{{ $payment -> pivot -> total }} - {{ $payment -> title }}</span>
                      </li>
                    @endforeach
                  </div>
              </div>
            </div>
          </div>

          {{-- products --}}
          <div id="products" class="col-xs-12">
            @foreach ($order -> products as $product)
              @include("admin.order.product", [
                "product" => $product,
                "editable" => $order -> status === \App\Models\Order::PENDING
              ])
              <div class="divider"></div>
            @endforeach
          </div>

          {{-- delivery --}}
          <div id="delivery" class="col-xs-12">
            <div class="padded-container">
              <h5>#Assign Delivery to Order</h5>
              @component("admin.components.form", [
                "method" => "get",
                "action" => route("admin.order.delivery", $order->id)
              ])
              
              @include("admin.components.select", [
                "name" => "delivery_id",
                "options" => $delivery,
                "old" => isset($order) ? $order->delivery_id : "",
                "label" => "Delivery Name",
                "class" => "removable-select-input-select"
              ])
                @include("admin.components.button", [
                  "icon"  => "add",
                  "label" => "Add"
                ])
                @endcomponent
            </div>
          </div>

          {{-- status --}}
          <div id="status" class="col-xs-12">
            <div class="row center-xs">
              <div class="change-status padded-container col-md-2 col-sm-4 col-xs-6" data-status="{{ \App\Models\Order::PENDING }}">
                <div class="flex flex-col align-center">
                  <div class="card">
                    <div class="card-content">
                      <img src="/assets/admin/images/pending{{
                        $order -> status >= \App\Models\Order::PENDING ? "-disabled" : ""
                      }}.png" class="responsive-img" />
                    </div>
                  </div>
                  <div>Pending</div>
                </div>
              </div>
              <div class="change-status padded-container col-md-2 col-sm-4 col-xs-6" data-status="{{ \App\Models\Order::CONFIRMED }}">
                <div class="flex flex-col align-center">
                  <div class="card">
                    <div class="card-content">
                      <img src="/assets/admin/images/confirmed{{
                        $order -> status >= \App\Models\Order::CONFIRMED ? "-disabled" : ""
                      }}.png" class="responsive-img" />
                    </div>
                  </div>
                  <div>Confirmed</div>
                </div>
              </div>
              <div class="change-status padded-container col-md-2 col-sm-4 col-xs-6" data-status="{{ \App\Models\Order::PREPARING }}">
                <div class="flex flex-col align-center">
                  <div class="card">
                    <div class="card-content">
                      <img src="/assets/admin/images/preparing{{
                        $order -> status >= \App\Models\Order::PREPARING ? "-disabled" : ""
                      }}.png" class="responsive-img" />
                    </div>
                  </div>
                  <div>Preparing</div>
                </div>
              </div>
              <div class="change-status padded-container col-md-2 col-sm-4 col-xs-6" data-status="{{ \App\Models\Order::ON_THE_WAY }}">
                <div class="flex flex-col align-center">
                  <div class="card">
                    <div class="card-content">
                      <img src="/assets/admin/images/on-the-way{{
                        $order -> status >= \App\Models\Order::ON_THE_WAY ? "-disabled" : ""
                      }}.png" class="responsive-img" />
                    </div>
                  </div>
                  <div>On The Way</div>
                </div>
              </div>
              <div class="change-status padded-container col-md-2 col-sm-4 col-xs-6" data-status="{{ \App\Models\Order::RETURNED }}">
                <div class="flex flex-col align-center">
                  <div class="card">
                    <div class="card-content">
                      <img src="/assets/admin/images/returned{{
                        $order -> status >= \App\Models\Order::RETURNED ? "-disabled" : ""
                      }}.png" class="responsive-img" />
                    </div>
                  </div>
                  <div>Returned</div>
                </div>
              </div>
              <div class="change-status padded-container col-md-2 col-sm-4 col-xs-6" data-status="{{ \App\Models\Order::DELIVERED }}">
                <div class="flex flex-col align-center">
                  <div class="card">
                    <div class="card-content">
                      <img src="/assets/admin/images/delivered{{
                        $order -> status >= \App\Models\Order::RETURNED ? "-disabled" : ""
                      }}.png" class="responsive-img" />
                    </div>
                  </div>
                  <div>Delivered</div>
                </div>
              </div>
              @component("admin.components.form", [
                "method" => "put",
                "action" => route("admin.order.status", $order -> id),
                "class" => "delete-form",
                "id" => "change-status"
              ])
                <input id="status-input" type="hidden" name="status" />
                <button type="submit" style="display: none"></button>
              @endcomponent
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="padded-container">
    <div class="card">
      <div class="card-content flex justify-start">
        @php
          $total = 0;
          foreach ($order -> products as $product)
            $total += $product -> pivot -> price * $product -> pivot -> quantity;
          $total += $order -> address -> city -> shipping_cost;
        @endphp
        <div class="flex align-center">
          <i class="material-icons right" style="font-size : 55px">attach_money</i>
        </div>
        <div>
          <div>Shipping Cost : {{ $order -> address -> city -> shipping_cost }}</div>
          <div style="font-size : 30px; font-weight : bold">Total : {{ $total }}</div>
        </div>
      </div>
    </div>
  </div>

@stop

@section("javascript")
<script>
  $(".change-status").on("click", function () {
    if ($(this).find("img").attr("src").indexOf("disabled") === -1) {
      $("#status-input").val($(this).data("status"));
      $("form#change-status button").click();
    }
  });
</script>
@stop