@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

@include('customers.partials.profile', compact('customer'))

@if($duplicates)

    <br><br>

    {!! Form::open(['route' => ['customers.profiles.merge', $customer->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">Duplicate Profiles</div>
        <div class="panel-body">

            @foreach($duplicates as $duplicate)
            <div class="duplicate-profile">
                <div class="merge-box checkbox pull-right">
                    <label>
                        <input type="checkbox" name="profiles[]" value="{!! $duplicate->id !!}" /> merge
                    </label>
                </div>
                @include('customers.partials.profile', ['customer' => $duplicate])
            </div>
            <br><hr><br>
            @endforeach

        </div>
        <div class="panel-footer">
            <button type="submit" id="merge-btn" class="btn btn-primary disabled pull-right" disabled>Merge Selected</button>
            <div class="clearfix"></div>
        </div>
    </div>

    {!! Form::close() !!}

@endif

    </div>
</div>

@stop

@section('inline-scripts')
@parent

<script>

$('input[name="profiles[]"]').on('click', function(){
    if ($('input[name="profiles[]"]:checked').length > 0) {
        $('#merge-btn').removeClass('disabled').prop('disabled', false);
    } else {
        $('#merge-btn').addClass('disabled').prop('disabled', true);
    }
});

</script>
@stop