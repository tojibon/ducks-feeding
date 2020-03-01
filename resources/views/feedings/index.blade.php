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
