@include("admin.components.input", [
  "name" => "name",
  "label" => "Name",
  "old"  => isset($category) ? $category -> name : "",

])

@include("admin.components.select", [
  "name" => "parent_id",
  "options" => $categories,
  "old" => isset($category) ? $category -> parent_id : "",
  "label" => "Parent Category",
  "class" => "removable-select-input-select"
])
