
<div class="row">
	<div class="col-md-2">
		@include("admin.components.input", [
		  "label" => "Start Date",
		  "name" => "start_date",
		  "type" => "date",
		  "old"  => request() -> input("start_date")
		])
	</div>

	<div class="col-md-2">
		@include("admin.components.input", [
		  "label" => "End Date",
		  "name" => "end_date",
		  "type" => "date",
		  "old"  => request() -> input("end_date")
		])
	</div>
	<div class="col-md-2">
		@include("admin.components.input", [
		  "label" => "Minimum Price",
		  "name" => "minimum_price",
		  "old"  => request() -> input("minimum_price")
		])
	</div>

	<div class="col-md-2">
		@include("admin.components.input", [
		  "label" => "Maximum Price",
		  "name" => "maximum_price",
		  "old"  => request() -> input("maximum_price")
		])
	</div>
	<div class="col-md-4">
		@include("admin.components.select", [
		  "label" => "Status",
		  "name" => "status",
		  "options" => ["Pending", "Confirmed", "On The Way", "Returned", "Delivered"],
		  "old"  => request() -> input("status")
		])
	</div>
</div>