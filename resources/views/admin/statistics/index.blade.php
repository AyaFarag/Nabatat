@extends("admin.layout.app")

@section("navbar")
  <h4>Statistics</h4>
@stop

@section("content")
  <div class="padded-container">
    <div class="card">
      <div class="card-content">
        <h2>General</h2>
        <div class="vertical-margin row">
          <div class="col-lg-6">
            <h5>Visits</h5>
            <div class="flex margin-top align-center">
              <i class="material-icons">person</i>
              <strong class="horizontal-margin" style="font-size : 20px">{{ $total_users }}</strong>
              <span class="washed-out"> Unique users</span>
            </div>
            <div class="flex margin-top align-center">
              <i class="material-icons">pageview</i>
              <strong class="horizontal-margin" style="font-size : 20px">{{ $total_visits }}</strong>
              <span class="washed-out"> Total hits</span>
            </div>
          </div>
          <div class="col-lg-6">
            <h5>Users</h5>
            <div class="flex margin-top align-center">
              <i class="material-icons">person</i>
              <strong class="horizontal-margin" style="font-size : 20px">{{ $total_registered_users }}</strong>
              <span class="washed-out"> Registered users</span>
            </div>
          </div>
        </div>
        <div class="divider"></div>
        <div class="vertical-margin row">
          <div class="col-lg-6">
            <h5>By Country</h5>
            <ul>
              @foreach ($by_country as $visits)
                <li>{{ $visits -> country }} : <strong>{{ $visits -> total }}</strong></li>
              @endforeach
            </ul>
          </div>
          <div class="col-lg-6">
            <h5>By City</h5>
            <ul>
              @foreach ($by_city as $visits)
                <li>{{ $visits -> city }} : <strong>{{ $visits -> total }}</strong></li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="padded-container">
    <div class="card">
      <div class="card-content">
        <h2>Orders</h2>
        <div class="vertical-margin row">
          <div class="col-lg-6">
            <h5>By Status</h5>
            <div class="flex margin-top align-center">
              <i class="material-icons">warning</i>
              <strong class="horizontal-margin" style="font-size : 20px">{{ $orders["pending"] }}</strong>
              <span class="washed-out"> Pending orders</span>
            </div>
            <div class="flex margin-top align-center">
              <i class="material-icons">check</i>
              <strong class="horizontal-margin" style="font-size : 20px">{{ $orders["confirmed"] }}</strong>
              <span class="washed-out"> Confirmed orders</span>
            </div>
            <div class="flex margin-top align-center">
              <i class="material-icons">local_shipping</i>
              <strong class="horizontal-margin" style="font-size : 20px">{{ $orders["on_the_way"] }}</strong>
              <span class="washed-out"> On the way orders</span>
            </div>
            <div class="flex margin-top align-center">
              <i class="material-icons">subdirectory_arrow_left</i>
              <strong class="horizontal-margin" style="font-size : 20px">{{ $orders["returned"] }}</strong>
              <span class="washed-out"> Returned orders</span>
            </div>
            <div class="flex margin-top align-center">
              <i class="material-icons">done_all</i>
              <strong class="horizontal-margin" style="font-size : 20px">{{ $orders["delivered"] }}</strong>
              <span class="washed-out"> Delivered orders</span>
            </div>

          </div>
          <div class="col-lg-6">
            <h5>Total Earnings</h5>
            <div class="flex margin-top align-center">
              <i class="material-icons">attach_money</i>
              <strong class="horizontal-margin" style="font-size : 20px">{{ $total_earned_money }}</strong>
              <span class="washed-out"> Through orders</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop