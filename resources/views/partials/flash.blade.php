<div class="col-lg-6 col-lg-offset-3">
    @if (Session::has('flash_notification.message'))
        <div class="alert alert-{!! Session::get('flash_notification.level') !!}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

            {!! Session::get('flash_notification.message') !!}
        </div>
    @endif
</div>