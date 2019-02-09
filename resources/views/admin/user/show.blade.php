@extends("admin.layout.app")

@section("navbar")
  <h4>{{ $user -> name }}</h4>
@stop

@section("content")
<div class="row">
	<div class="padded-container col-xs-12">
	  	<div class="card">
		    <div class="card-content">
		    	<h3>Profile Info</h3>
		      	<div class="vertical-margin row">
			        <div class="col-md-6 margin-top">
			          <h5 class="flex align-center"><i class="material-icons">info</i><span class="margin-left small">General Info</span></h5>
			          <div class="flex margin-top align-center">
			            <span class="washed-out">Name : </span>
			            <strong class="horizontal-margin" style="font-size : 20px">{{ $user -> name }}</strong>
			          </div>
			          <div class="flex margin-top align-center">
			            <span class="washed-out">Email : </span>
			            <strong class="horizontal-margin" style="font-size : 20px">{{ $user -> email }}</strong>
			          </div>
			        </div>
			        <div class="col-md-6 margin-top">
			          <h5 class="flex align-center"><i class="material-icons">place</i><span class="margin-left small">Addresses</span></h5>
			          <div class="margin-top">
				          @foreach ($user -> addresses as $address)
				            <div>{{ $address -> address }} - {{ $address -> city -> name }}</div>
					        @endforeach
					      </div>
			        </div>
		      	</div>
		    </div>
	  	</div>
	</div>
	<div class="padded-container col-xs-12 col-md-6">
	  <div class="card full-height">
	    <div class="card-content full-height">
	    	<h3>Statistics</h3>
	    	<div class="flex margin-top align-center">
          	<span class="washed-out">Money spent : </span>
          	<strong class="horizontal-margin" style="font-size : 20px">{{ $money_spent }}</strong>
        </div>
	    	<div class="flex margin-top align-center">
          	<span class="washed-out">Total orders : </span>
          	<strong class="horizontal-margin" style="font-size : 20px">{{ $user -> orders() -> count() }}</strong>
        </div>
	    	<div class="flex margin-top align-center">
          	<span class="washed-out">Average product ratings : </span>
          	<strong class="horizontal-margin" style="font-size : 20px">{{ round($user -> rates() -> avg("rate")) }}</strong>
        </div>
	    </div>
		</div>
	</div>
	<div class="padded-container col-xs-12 col-md-6">
  	<div class="card full-height">
    	<div class="card-content full-height">
	    	<h3>Orders</h3>
	    	<div class="margin-top" style="max-height : 200px; overflow-y: scroll">
        	<ul>
            @foreach ($user -> orders() -> latest() -> get() as $order)
              	<li><a target="_blank" href="{{ route("admin.order.show", $order -> id) }}">#{{ $order -> id }}. {{ $order -> created_at -> toDayDateTimeString() }}</a></li>
            @endforeach
        	</ul>
      	</div>
    	</div>
		</div>
	</div>
	<div class="padded-container col-xs-12 col-md-6">
  	<div class="card full-height">
    	<div class="card-content full-height">
	    	<h3>Product Reviews</h3>
	    	<div class="margin-top" style="max-height : 200px; overflow-y: scroll">
        	<ul>
            @foreach ($user -> rates() -> where("status", 1) -> latest() -> get() as $rating)
            	<li class="text-overflow tooltipped" data-position="top" data-tooltip="{{ $rating -> comment }}"><b>{{ $rating -> rate }} stars</b> | {{ $rating -> comment }}</li>
            @endforeach
        	</ul>
      	</div>
    	</div>
		</div>
	</div>
	<div class="padded-container col-xs-12 col-md-6">
  	<div class="card full-height">
    	<div class="card-content full-height">
	    	<h3>Requests</h3>
	    	<div class="margin-top" style="max-height : 200px; overflow-y: scroll">
        	<ul>
            @foreach ($user -> requests() -> latest() -> get() as $request)
              	<li><a target="_blank" href="{{ route("admin.request.show", $request -> id) }}">#{{ $request -> id }}. {{ $request -> created_at -> toDayDateTimeString() }}</a></li>
            @endforeach
        	</ul>
      	</div>
    	</div>
		</div>
	</div>
</div>
@stop