@include("admin.components.select", [
  "label" => "Products",
  "name" => "product_id",
  "options" => $product,
  "old" => isset($offer) ? $offer -> product_id : "",
  "class" => "removable-select-input-select"
])

@include("admin.components.input", [
  "label" => "Discount",
  "name" => "discount",
  "type" => "number",
  "old"  => isset($offer) ? $offer -> discount * 100 : ""
])

@include("admin.components.input", [
  "label" => "End Date",
  "name" => "ended_at",
  "type" => "date",
  "old"  => isset($offer) ? explode(" ", $offer -> ended_at)[0] : ""
])


<div>

</div>