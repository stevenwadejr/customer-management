@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <h2>{!! $action !!} Customer</h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        {!! Form::model($customer, ['route' => $route, 'method' => $action === 'Add' ? 'POST' : 'PUT']) !!}

        <div class="form-group">
            <label>Name</label>
            <div class="input-pair">
                {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First']) !!}
                {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last']) !!}
            </div>
        </div>

        <hr>

        <div class="form-group">
            <button type="button" class="btn btn-success btn-xs pull-right new-repeatable" data-template="email-template">
                <i class="glyphicon glyphicon-plus"></i>
            </button>
            <label>Emails</label>
            @foreach($customer->emails as $email)
            <div class="input-group repeatable">
                {!! Form::email('email[]', $email->address, ['class' => 'form-control', 'placeholder' => 'jon@example.com']) !!}
                <span class="input-group-btn">
                    <button class="btn btn-danger remove-repeatable" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                </span>
            </div><!-- /input-group -->
            @endforeach
        </div>

        <hr>

        <div class="form-group">
            <button type="button" class="btn btn-success btn-xs pull-right new-repeatable" data-template="phone-template">
                <i class="glyphicon glyphicon-plus"></i>
            </button>
            <label>Phones</label>
            @foreach($customer->phones as $phone)
            <div class="input-group repeatable">
                {!! Form::text('phone[]', $phone->number, ['class' => 'form-control']) !!}
                <span class="input-group-btn">
                    <button class="btn btn-danger remove-repeatable" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                </span>
            </div><!-- /input-group -->
            @endforeach
        </div>

        <div class="form-group pull-right">
            <button type="submit" class="btn btn-primary">{!! $action === 'Add' ? 'Add' : 'Update' !!}</button>
            <a href="{!! route('customers.index') !!}" class="btn btn-default">Cancel</a>
        </div>

        {!! Form::close() !!}
    </div>
</div>
<script type="text/template" id="email-template">
    <div class="input-group repeatable">
        {!! Form::email('email[]', null, ['class' => 'form-control', 'placeholder' => 'jon@example.com']) !!}
        <span class="input-group-btn">
            <button class="btn btn-danger remove-repeatable" type="button"><i class="glyphicon glyphicon-remove"></i></button>
        </span>
    </div><!-- /input-group -->
</script>
<script type="text/template" id="phone-template">
    <div class="input-group repeatable">
        {!! Form::text('phone[]', null, ['class' => 'form-control']) !!}
        <span class="input-group-btn">
            <button class="btn btn-danger remove-repeatable" type="button"><i class="glyphicon glyphicon-remove"></i></button>
        </span>
    </div><!-- /input-group -->
</script>
@stop

@section('inline-scripts')
<script>

$('.new-repeatable').on('click', function(){
    var $template = $('#' + $(this).data('template')).html();
    $(this).parents('.form-group').append($template);
});
$(document).on('click', '.remove-repeatable', function(){
    $(this).parents('.repeatable').remove();
});

</script>
@stop