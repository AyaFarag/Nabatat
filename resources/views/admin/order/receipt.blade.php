@extends("admin.layout.app")

@section("navbar")
  <h4 class="hide-on-small-only">Order Receipt</h4>
  @include("admin.components.button", [
    "placeholder" => "Print",
    "class" => "print",
    "label" => "Print",
    "color" => "secondary",
    "icon" => "print"
  ])
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content ">
        <div class="row">
            @if($order->delivery_id == null )
                <div class="col col-xs-12"> 
                    <h4 class="text-danger margin-auto">
                        <a href="{{ route("admin.order.show", $order -> id) }}">Please assign order delivery first</a>
                    </h4>
                </div>
            @else
            
          <div class="col col-xs-6" style="">
          {{-- info --}}
            <div id="info" style="width:100%">
              <div class="padded-container">
                <h5 class="flex space-between">
                  <strong>Order #{{ $order -> code }}</strong>

                </h5>
                <div class="margin-top">
                  <div>Name : <span class="washed-out">{{ $order -> user -> name }}</span></div>
                  
                  @foreach ($order -> user -> phones as $phone)
                  <div>Phone : <span class="washed-out">{{ $phone -> phone }}</span></div>
                  @endforeach
                      

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
                    </ul>

                </div>
              </div>
            </div>
          </div>
          <div id="info" style=" width:100%">
            <div class="padded-container">
              <h5 class="flex space-between">
                <strong>Delivery</strong>

              </h5>
              <div class="margin-top">
                <div>Name : <span class="washed-out">{{ $order->delivery['name'] }}</span></div>

              </div>
            </div>
          </div>
        </div>
          {{--  end  --}}

          {{-- delivery --}}
          
          {{--  end  --}}
          {{-- products --}}
          <div id="info" class="col col-xs-6" style=" width:100%">
            <div class="padded-container">
              <h5 class="flex space-between">
                <strong>Products</strong>

              </h5>
              @foreach ($order -> products as $product)
              <div class="margin-top">
                    <div>Name : <span class="washed-out"><strong>{{ $product -> name }}</strong></span></div>
                    <div>Quantity : <span class="washed-out"><strong>{{ $product -> pivot -> quantity }}</strong></span></div>
                    <div>Price : <span class="washed-out"><strong>{{ $product -> pivot -> regular_price }}</strong></span></div>
                    @if ($product -> pivot -> price !== $product -> pivot -> regular_price)
                      <div>Discount : <span class="washed-out"><strong>{{ $product -> pivot -> regular_price - $product -> pivot -> price }}</strong></span></div>
                      <div>Price after discount : <span class="washed-out"><strong>{{ $product -> pivot -> price }}</strong></span></div>
                    @endif
                    <div>Total : <span class="washed-out"><strong>{{ $product -> pivot -> price * $product -> pivot -> quantity }}</strong></span></div>
                </div>
              @endforeach
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
  @endif  

@stop

@section("css")
<style>
@media print {
  .sidenav, nav, .sidenav-trigger {
    display : none;
  }
  .card {
    box-shadow : none;
    border : 2px solid black;
  }
}

body > div.main-section > nav > div > div > button > i {
  height : 36px!important;
  line-height : 36px!important;
}
</style>
@stop

@section("javascript")
<script>
  $(".change-status").on("click", function () {
    if ($(this).find("img").attr("src").indexOf("disabled") === -1) {
      $("#status-input").val($(this).data("status"));
      $("form#change-status button").click();
    }
  });

  $("button.print").on("click", function () {
    window.print();
  });
</script>
@stop