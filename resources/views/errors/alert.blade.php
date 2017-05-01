{{-- Form validation or other error messages in alert box--}}
@if (count(@$errors) > 0)
    <div class="flash-alert alert alert-danger {{ $id or null }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @foreach($errors->all() as $error)
            {!! $error !!} <br>
        @endforeach
    </div>
@endif

{{-- Session alerts - Can close this alert box --}}
@if (session()->has('flash_message'))
    <div class="flash-alert alert alert-{{ session('flash_message.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! session('flash_message.message')  !!}
    </div>
@endif

{{-- Session alerts - Cannot close this alert box --}}
@if (session()->has('flash_message_overlay'))
    <div class="flash-alert alert alert-{{ session('flash_message_overlay.level') }}">
        {!! session('flash_message_overlay.message')  !!}
    </div>
@endif

<div class="alert-field" id="alert-field"></div>