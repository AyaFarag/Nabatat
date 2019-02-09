
{{--  title  --}}
@include("admin.components.input", [
  "label" => "Service Title",
  "name" => "title",
  "old"  => isset($service) ? $service -> title : ""
])

{{--  description  --}}
@include("admin.components.textarea", [
  "name" => "description",
  "label" => "description",
  "rows" => 7,
  "oldValue"  => isset($service) ? $service -> description : ""
])

{{--  parent service  --}}
@include("admin.components.select", [
  "label" => "Parent",
  "name" => "parent_id",
  "options" => $services,
  "class" => "removable-select-input-select"
])