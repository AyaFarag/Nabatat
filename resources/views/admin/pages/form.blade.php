@include("admin.components.input", [
  "name"     => "title",
  "label"    => "Title",
  "readonly" => true,
  "old"      => isset($page) ? $page -> title : ""
])

@include("admin.components.textarea", [
  "name"  => "content",
  "label" => "Content",
  "old"   => isset($page) ? $page -> content : ""
])

<div>

</div>