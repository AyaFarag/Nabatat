@extends("admin.layout.app")

@section("css")
<link rel="stylesheet" type="text/css" href="/assets/admin/css/widgets.css" />
@append

@section("navbar")
  <h4>Dashboard</h4>
@stop

@section("content")
<div class="row cards">
    {{-- CLOCK --}}
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card full-height">
            <div class="card-content full-height">
                @include("admin.widgets.clock")
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card full-height">
            <div class="card-content full-height">
                <h4 class="text-centered margin-bottom"><b>Today</b></h4>
                <div class="flex" style="font-size : 18px">
                    <i class="material-icons">shopping_basket</i>
                    <b class="margin-left small">{{ $ordersCount }} Orders</b>
                </div>
                <div class="flex" style="font-size : 18px">
                    <i class="material-icons">person</i>
                    <b class="margin-left small">{{ $registrationCount }} Registrations</b>
                </div>
                <div class="flex" style="font-size : 18px">
                    <i class="material-icons">attach_money</i>
                    <b class="margin-left small">{{ $earnings }} Earnings</b>
                </div>
                <div class="flex" style="font-size : 18px">
                    <i class="material-icons">local_florist</i>
                    <b class="margin-left small">{{ $serviceRequestsCount }} Service Requests</b>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card full-height">
            <div class="card-content full-height">
                <h4 class="text-centered margin-bottom"><b>Special Users</b></h4>
                <div style="max-height : 200px; overflow-y: scroll">
                    <ul>
                        @foreach ($specialUsers as $user)
                            <li><a href="{{ route("admin.user.show", $user -> id) }}">{{ $loop -> iteration }}. {{ $user -> name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ORDER TYPES COUNT CHART --}}

    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div class="card chart full-height">
            <div class="card-content no-padding full-height flot-chart">
                <h4 class="text-centered margin-bottom"><b>Orders</b></h4>
                <div id="order-types-chart" class="chart" style="height : 200px"></div>
                <div id="order-types-chart-legend" class="legend flex justify-center"></div>
            </div>
        </div>
    </div>
</div>
@stop

@section("javascript")
<script src="/assets/admin/js/jquery.flot.min.js"></script>
<script src="/assets/admin/js/jquery.flot.pie.min.js"></script>
<script>
var plot = $.plot("#order-types-chart", {!! json_encode($orderTypesData) !!}, {
    series : {
        pie : {
            show   : true,
            radius : 1,
            label  : {
                show   : false
            }
        }
    },
    legend: {
        show      : true,
        noColumns : 0,
        container : $("#order-types-chart-legend")
    },
    grid : {
        hoverable : true
    }
});

$(window).resize(function () {
    var width = $(".flot-chart .chart").width()
    $(".flot-chart .chart > *").width(width);
    plot.resize();
    plot.draw();
});
</script>
@append