@include("admin.components.input", [
  "name" => "name",
  "old"  => isset($user) ? $user -> name : ""
])
@include("admin.components.input", [
  "name" => "email",
  "old"  => isset($user) ? $user -> email : ""
])

<div class="removable-input-container">
  <h5 class="margin-bottom big">Phone Numbers</h5>
  <div class="removable-input-items">
    @foreach (empty($user -> phones) || !count($user -> phones) ? [""] : $user -> phones as $phone_number)
      <div class="flex removable-input-group">
        <div class="flex align-center margin-right">
          @include("admin.components.rounded-button", [
            "icon"    => "close",
            "tooltip" => "Remove",
            "class"   => "remove-input"
          ])
        </div>
        <div style="flex : 1">
          @include("admin.components.input", [
            "name"  => "phones[" . $loop -> index . "]",
            "label" => "Phone Number",
            "old"   => $phone_number -> phone
          ])
        </div>
      </div>
    @endforeach
  </div>
  @include("admin.components.button", [
    "notSubmit" => true,
    "label"     => "Add",
    "icon"      => "add",
    "class"     => "add-input",
    "color"     => "secondary"
  ])
</div>
<div class="removable-input-container">
  <h5 class="margin-bottom big">Addresses</h5>
  <div class="removable-input-items">
    @foreach ((empty($user -> addresses) || !count($user -> addresses) ? [new App\Models\Address()] : $user -> addresses) as $address)
      <div class="flex removable-input-group">
        <div class="flex align-center margin-right">
          @include("admin.components.rounded-button", [
            "icon"    => "close",
            "tooltip" => "Remove",
            "class"   => "remove-input"
          ])
        </div>
        <div style="flex : 1">
          @include("admin.components.input", [
            "name"  => "addresses[" . $loop -> index . "][address]",
            "label" => "Address",
            "old"   => $address -> address
          ])
          @include("admin.components.select", [
            "name"    => "addresses[" . $loop -> index . "][city_id]",
            "label"   => "City",
            "options" => $cities,
            "old"     => $address -> city_id
          ])
        </div>
      </div>
    @endforeach
  </div>
  @include("admin.components.button", [
    "notSubmit" => true,
    "label"     => "Add",
    "icon"      => "add",
    "class"     => "add-input",
    "color"     => "secondary"
  ])
</div>

@include("admin.components.input", [
  "name"      => "password",
  "type"      => "password",
  "dontFlash" => true
])
@include("admin.components.input", [
  "name"      => "password_confirmation",
  "type"      => "password",
  "label"     => "Password Confirmation",
  "dontFlash" => true
])
<div>
  <h5 class="margin-bottom">Account Status</h5>
  @include("admin.components.switch", [
    "name"     => "activated",
    "offLabel" => "not activated",
    "onLabel"  => "activated",
    "old"      => isset($user) ? $user -> activated : false
  ])
</div>