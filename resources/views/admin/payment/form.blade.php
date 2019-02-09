{{--  name  --}}
@include("admin.components.input", [
  "name"     => "title",
  "label"    => "Name",
  "old"      => $payment -> title,
  "readonly" => true
])
<div>
  <h5 class="margin-bottom">Status</h5>
  @include("admin.components.switch", [
    "name"     => "status",
    "offLabel" => "Inactive",
    "onLabel"  => "Active",
    "old"      => $payment -> status == 1
  ])
</div>