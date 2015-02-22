@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th># of Duplicates</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{!! $customer->first_name . ' ' . $customer->last_name !!}</td>
                    <td>{!! $customer->num_duplicates !!}</td>
                    <td>
                        <a href="{!! route('customers.duplicates.view', ['id' => $customer->id]) !!}" class="btn btn-primary btn-xs">view profile</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop