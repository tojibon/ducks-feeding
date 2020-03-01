@extends('layouts.default')

@section('title')
    Submit Your Feeding
    @parent
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header">Daily Feedings</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">&nbsp;</div>
            <div class="col-lg-4">
                <input type="text" name="dates" value="{{ date('m-d-Y', strtotime(app('request')->input('start_date', date('Y-m-d')))) }} - {{ date('m-d-Y', strtotime(app('request')->input('end_date', date('Y-m-d')))) }}" class="form-control mb-2">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Food Type</th>
                        <th>Food</th>
                        <th>Location</th>
                        <th>Feeding Time</th>
                        <th>Total Ducks</th>
                        <th>Amount of foods</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $key=>$record)
                            <tr>
                                <td>{{$record->food_type->name}}</td>
                                <td>{{$record->food->name}}</td>
                                <td>{{$record->location->name}}</td>
                                <td>{{$record->feeding_time}}</td>
                                <td>{{$record->total_ducks}}</td>
                                <td>{{$record->amount_foods}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <p>No duck feeding for today!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $records->links() }}
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            $('input[name="dates"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                $('input[name="dates"]').val(start + ' - ' + end);
                var start_date = start.format('YYYY-MM-DD');
                var end_date = end.format('YYYY-MM-DD');
                var current_query_string = window.location.href.split('?');
                var current_query_string_append = [];
                if (current_query_string[1]) {
                    var current_query_arr = current_query_string[1].split('&');
                    for(var i=0; i<current_query_arr.length; i++) {
                        if (current_query_arr[i].indexOf('date') > 0) {
                        } else {
                            current_query_string_append.push(current_query_arr[i]);
                        }
                    }
                }

                if (current_query_string_append.length > 0) {
                    window.location.href = "{{route('feedings.overview')}}?" + "start_date=" + start_date + "&end_date=" + end_date + '&' + current_query_string_append.join('&');
                } else {
                    window.location.href = "{{route('feedings.overview')}}?" + "start_date=" + start_date + "&end_date=" + end_date;
                }

                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
@stop
