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
            <div class="col-lg-12">
                <form class="form-inline  mb-2 content-align-right">
                    <div class="form-group">
                        <select name="food_type_id" id="food_type_id" class="form-control">
                            <option value="">Select Food Type</option>
                            @foreach($food_types as $food_type)
                                <option value="{{$food_type->id}}"
                                        @if (!empty(app('request')->input('food_type_id')) && $food_type->id == app('request')->input('food_type_id'))
                                        selected="selected"
                                    @endif>{{$food_type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="food_id" id="food_id" class="form-control">
                            <option value="">Select Food</option>
                            @foreach($foods as $food)
                                <option value="{{$food->id}}"
                                        @if (!empty(app('request')->input('food_id')) && $food->id == app('request')->input('food_id'))
                                        selected="selected"
                                    @endif>{{$food->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="location_id" id="location_id" class="form-control">
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{$location->id}}"
                                        @if (!empty(app('request')->input('location_id')) && $location->id == app('request')->input('location_id'))
                                        selected="selected"
                                    @endif>{{$location->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" name="dates" value="{{ date('m-d-Y', strtotime(app('request')->input('start_date', date('Y-m-d')))) }} - {{ date('m-d-Y', strtotime(app('request')->input('end_date', date('Y-m-d')))) }}" class="form-control">
                </form>
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
                        <th class="text-right">Total Ducks</th>
                        <th class="text-right">Amount of foods (KG)</th>
                        <th class="text-right">Foods Per Duck (KG)</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $key=>$record)
                            <tr>
                                <td>{{$record->food_type->name}}</td>
                                <td>{{$record->food->name}}</td>
                                <td>{{$record->location->name}}</td>
                                <td>{{$record->feeding_time}}</td>
                                <td class="text-right">{{$record->total_ducks}}</td>
                                <td class="text-right">{{$record->amount_foods}}</td>
                                <td class="text-right">{{number_format(($record->total_ducks / $record->amount_foods), 2)}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
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
            $(document).on('change', '#food_type_id', function () {
                if (parseInt($(this).val()) > 0) {
                    var food_type_id = $(this).val();

                    $.get("{{route('foods')}}?food_type_id=" + food_type_id, function (data) {
                        console.log(data);
                        var select_food_id = $('#food_id');
                        select_food_id.find('option').remove();
                        $.each(data, function (value, food) {
                            select_food_id.append($('<option />', {value: food.id, text: food.name}));
                        });
                    })
                } else {
                    console.log('Food type is not selected');
                }
            });

            $('input[name="dates"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                $('input[name="dates"]').val(start + ' - ' + end);
                var start_date = start.format('YYYY-MM-DD');
                var end_date = end.format('YYYY-MM-DD');
                var current_query_string = window.location.href.split('?');
                var current_query_string_append = [];
                current_query_string_append.push('food_type_id=' + $('#food_type_id').val());
                current_query_string_append.push('food_id=' + $('#food_id').val());
                current_query_string_append.push('location_id=' + $('#location_id').val());

                if (current_query_string[1]) {
                    var current_query_arr = current_query_string[1].split('&');
                    for(var i=0; i<current_query_arr.length; i++) {
                        if (current_query_arr[i].indexOf('date') > 0 || current_query_arr[i].indexOf('id') > 0) {
                        } else {
                            current_query_string_append.push(current_query_arr[i]);
                        }
                    }
                }

                window.location.href = "{{route('feedings.overview')}}?" + "start_date=" + start_date + "&end_date=" + end_date + '&' + current_query_string_append.join('&');

                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
@stop
