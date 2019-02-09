@extends("admin.layout.app")

@section("navbar")
  <h4>{{ucfirst($data['reportName'])}}</h4>
  <a href="{{URL::to('admin/report/download/'.$data['reportName'])}}">Download</a>
@stop

@section("content")
  <div class="padded-container">
  	<div class="card">
  		<div class="card-content">
        @component("admin.components.form", [
          "method" => "get",
          'noCsrf' => true,
          "action" => url("admin/report/run/".$data['reportName'])
        ])
          @include("admin.reports.form.".$data['reportName'])
          @include("admin.components.button", [
            "label" => "Search"
          ])
        @endcomponent
      </div>
  	</div>
    <div class="card">
      <div class="card-content no-padding">
        @php
  			$hasItems = $data['objects'] -> count() > 0;
		@endphp
		@if ($hasItems)
  		<table>
    		<thead>
			  <tr>
			      <th></th>
			      @foreach($data['columns'] as  $column)
			        <th>{{ $column }}</th>
			      @endforeach
            @if($data['reportName'] == 'orders')
            <th>Products</th>
            @endif
			  </tr>
			</thead>

    <tbody>
      @foreach ($data['objects'] as $item)
        <tr>
          @php
            $actions_count = 0;
            if (!(isset($noEdit) && $noEdit))
              $actions_count += 1;
            if (!(isset($noDelete) && $noDelete))
              $actions_count += 1;
            $actions_count += isset($actions) ? count($actions) : 0;
          @endphp
          <td class="action size-{{$actions_count}}">
            @if (!(isset($noEdit) && $noEdit) && isset($baseRouteName) && isset($model) && Auth::guard("admin") -> user() -> can("updata", $model))
              <a href="{{ route($baseRouteName . '.edit', $item -> id) }}">
                @include("admin.components.rounded-button", [
                  "icon"    => "edit",
                  "tooltip" => "Edit"
                ])
              </a>
            @endif
            @if (!(isset($noDelete) && $noDelete) && isset($baseRouteName) && isset($model) && Auth::guard("admin") -> user() -> can("delete", $model))
              @component("admin.components.form", [
                "class"  => "delete-form",
                "method" => "DELETE",
                "action" => route($baseRouteName . ".destroy", $item -> id)
              ])
                @include("admin.components.rounded-button", [
                  "icon"    => "delete",
                  "tooltip" => "Delete"
                ])
              @endcomponent
            @endif
            @if (isset($actions))
              @foreach ($actions as $action)
                @if (!(array_key_exists("visible", $action) && !$action["visible"]))
                  @if (array_key_exists("isForm", $action))
                    @component("admin.components.form", [
                      "method" => array_key_exists("method", $action) ? $action["method"] : "POST",
                      "action" => $action["route"]
                    ])
                      @include("admin.components.rounded-button", [
                        "icon"    => $action["icon"],
                        "tooltip" => $action["tooltip"]
                      ])
                    @endcomponent
                  @else
                    <a href="{{ $action["route"]($item) }}">
                      @include("admin.components.rounded-button", [
                        "icon"    => $action["icon"],
                        "tooltip" => $action["tooltip"]
                      ])
                    </a>
                  @endif
                @endif
              @endforeach
            @endif
          </td>
          @foreach($data['columns'] as $key => $column)
              <td>{{ $item -> { $key } }}</td>
          @endforeach
          @if($data['reportName'] == 'orders' && $item->products)
          <td>
            <table>
                <th>Name</th>
                <th>Price</th>
               @foreach($item->products as $product)
              <tr>
              <td>{{$product->name}}</td>
              <td>{{$product->price}}</td>
              </tr>
              @endforeach
            </table>
           
          </td>
          @endif
        </tr>
      @endforeach
    </tbody>
  </table>
  @if ($data['objects'] instanceof \Illuminate\Pagination\LengthAwarePaginator && $data['objects'] -> total() > $data['objects'] -> perPage())
    <div class="text-centered vertical-padding tiny">
      {{ $data['objects'] -> links() }}
    </div>
  @endif
@else
  <h4 class="text-centered text-danger vertical-padding big">Not found any {{ucfirst($data['reportName'])}}</h4>
@endif
      </div>
    </div>
  </div>
@stop
