
<div class="row">
	<div class="col-md-3">
		@include("admin.components.input", [
		  "label" => "Start Date",
		  "name" => "start_date",
		  "type" => "date",
		  "old"  => isset($city) ? $city -> name : ""
		])
	</div>

	<div class="col-md-3">
		@include("admin.components.input", [
		  "label" => "End Date",
		  "name" => "end_date",
		  "type" => "date",
		  "old"  => isset($city) ? $city -> name : ""
		])
	</div>
</div>