@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="pull-right">
            <a href="{!! route('customers.create') !!}" class="btn btn-success">
                <i class="glyphicon glyphicon-plus"></i> Add Customer
            </a>
            &nbsp;
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Tools <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{!! route('customers.duplicates') !!}">Find Duplicates</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{!! $customer->first_name . ' ' . $customer->last_name !!}</td>
                    <td>
                        <span class="details">
                            @foreach ($customer->emails as $email)
                            <div><i class="glyphicon glyphicon-envelope"></i> {!! $email->address !!}</div>
                            @endforeach
                            @if($customer->emails)
                            <br>
                            @endif
                            @foreach ($customer->phones as $phone)
                            <div><i class="glyphicon glyphicon-earphone"></i> {!! $phone->number !!}</div>
                            @endforeach
                        </span>

                        {!! Form::open(['route' => ['customers.destroy', $customer->id], 'method' => 'delete']) !!}
                        <button type="button" class="btn btn-default btn-xs view-details">details</button>
                        <a href="{!! route('customers.edit', ['id' => $customer->id]) !!}" class="btn btn-primary btn-xs">edit</a>
                        <button type="submit" class="btn btn-danger btn-xs confirm">remove</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            {!! $customers->render() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="customer-details">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Customer Details</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop

@section('inline-scripts')
<script>

$('.confirm').on('click', function(){
    return confirm('Are you sure you want to do that?');
});

$('.view-details').on('click', function(){
    var modalHTML = $(this).parents('td').find('.details').html();
    $('#customer-details').find('.modal-body p').html(modalHTML);
    $('#customer-details').modal('show');
});

</script>
@stop