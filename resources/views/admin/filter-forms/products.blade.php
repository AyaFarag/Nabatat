
<div class="row">
	<div class="col-md-4 col-xs-12">
		@include("admin.components.input", [
		  "label" => "Minimum Price",
		  "name" => "minimum_price",
		  "type" => "number",
		  "old"  => request() -> input("minimum_price")
		])
	</div>

	<div class="col-md-4 col-xs-12">
		@include("admin.components.input", [
		  "label" => "Maximum Price",
		  "name" => "maximum_price",
		  "type" => "number",
		  "old"  => request() -> input("maximum_price")
		])
	</div>
	<div class="col-md-4 col-xs-12">
		@include("admin.components.select", [
		  "label" => "Category",
		  "name" => "category_id",
		  "options" => $categories,
		  "old"  => request() -> input("category_id")
		])
	</div>
	<div class="col-md-6 col-xs-12 row">
	  <div class="col-xs-4">Has discount</div>
	  <div class="col-xs-6">
		  @include("admin.components.switch", [
		    "name"     => "has_discount",
		    "offLabel" => "no",
		    "onLabel"  => "yes",
		    "old"      => request() -> filled("has_discount")
		  ])
		</div>
	</div>
	<div class="col-md-6 col-xs-12 row">
	  <div class="col-xs-4">Out of stock</div>
	  <div class="col-xs-6">
		  @include("admin.components.switch", [
		    "name"     => "out_of_stock",
		    "offLabel" => "no",
		    "onLabel"  => "yes",
		    "old"      => request() -> filled("out_of_stock")
		  ])
		</div>
	</div>
</div>