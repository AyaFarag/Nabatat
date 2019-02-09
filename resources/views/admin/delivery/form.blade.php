{{-- name --}}
@include("admin.components.input", [
  "label" => "Name",
  "name" => "name",
  "old"  => isset($delivery) ? $delivery -> name : ""
])
{{-- phone --}}
@include("admin.components.input", [
  "label" => "Phone",
  "name" => "phone",
  "old"  => isset($delivery) ? $delivery -> phone : ""
])
{{-- national id --}}
@include("admin.components.input", [
  "label" => "NationalId",
  "name" => "nationalId",
  "old"  => isset($delivery) ? $delivery -> nationalId : ""
])

{{--  images  --}}
@include("admin.components.file", [
  "label" => "Image",
  "name" => "image",
])

<div>

</div>