@extends("admin.layout.app")

@section("navbar")
  <h4>Reports</h4>
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content">
        <div class="vertical-margin row">
          <div class="col-lg-6">
            <div class="flex margin-top align-center">
              <i class="material-icons">store</i>
              <strong class="horizontal-margin" style="font-size : 20px"></strong>
              <a href="{{URL::to('admin/report/run/products')}}"><span class="washed-out">Products</span></a>
            </div>
            <div class="flex margin-top align-center">
              <i class="material-icons">shopping_basket</i>
              <strong class="horizontal-margin" style="font-size : 20px"></strong>
              <a href="{{URL::to('admin/report/run/orders')}}"><span class="washed-out">Orders</span></a>
            </div>
            
          </div>
          <div class="col-lg-6">
            <div class="flex margin-top align-center">
              <i class="material-icons">person</i>
              <strong class="horizontal-margin" style="font-size : 20px"></strong>
              <a href="{{URL::to('admin/report/run/users')}}"><span class="washed-out">Users</span></a>
            </div>
            <div class="flex margin-top align-center">
              <i class="material-icons">local_offer</i>
              <strong class="horizontal-margin" style="font-size : 20px"></strong>
              <a href="{{URL::to('admin/report/run/offers')}}"><span class="washed-out">Offers</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop