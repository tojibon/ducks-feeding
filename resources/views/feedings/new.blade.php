@extends('layouts.default')

@section('title')
    Submit Your Feeding
    @parent
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header">Submit Your Feeding</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form role="form" method="POST" action="{{ route('feedings.submit') }}">
                    @csrf
                    <fieldset>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="feeding_time">Time</label>
                            <input type="datetime-local" class="form-control" id="feeding_time" name="feeding_time"
                                   value="{{old('feeding_time')}}"
                                   placeholder="When you feed your ducks?">
                        </div>
                        <div class="form-group">
                            <label for="food_type_id">Food Type</label>
                            <select name="food_type_id" id="food_type_id" class="form-control">
                                <option value="">Select Food Type</option>
                                @foreach($food_types as $food_type)
                                    <option value="{{$food_type->id}}"
                                            @if (!empty(old('food_type_id')) && $food_type->id == old('food_type_id'))
                                            selected="selected"
                                        @endif>{{$food_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="food_id">Food</label>
                            <select name="food_id" id="food_id" class="form-control">
                                <option value="">Select Food</option>
                                @foreach($foods as $food)
                                    <option value="{{$food->id}}"
                                            @if (!empty(old('food_id')) && $food->id == old('food_id'))
                                            selected="selected"
                                        @endif>{{$food->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="location_id">Location</label>
                            <select name="location_id" class="form-control">
                                <option value="">Select Location</option>
                                @foreach($locations as $location)
                                    <option value="{{$location->id}}"
                                            @if (!empty(old('location_id')) && $location->id == old('location_id'))
                                            selected="selected"
                                        @endif>{{$location->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="total_ducks">Total Ducks</label>
                            <input type="number" class="form-control" name="total_ducks" id="total_ducks"
                                   value="{{old('total_ducks')}}"
                                   placeholder="Number of ducks you fed?">
                        </div>
                        <div class="form-group">
                            <label for="amount_foods">Amount of foods</label>
                            <input type="text" class="form-control" name="amount_foods" id="amount_foods"
                                   value="{{old('amount_foods')}}"
                                   placeholder="Total weight of your foods?">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="daily_recurring" id="daily_recurring"
                                   value="1"
                                   @if (old('daily_recurring'))
                                   checked="checked"
                                @endif />
                            <label class="form-check-label" for="daily_recurring">Is Recurring</label>
                            <small id="daily_recurring_help" class="form-text text-muted">Check this only if you want to
                                automate this for everyday.</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </fieldset>
                </form>
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
        });
    </script>
@stop
