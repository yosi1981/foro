@extends('layouts.email')
@section('content')
    <p>
        You recently registered with this email on {{ site('site-name') }}. Thank you for registering!
    </p>
    <p>
        Before you can log in, you must confirm your account. You can do so by
        <a title="Confirm Email" href="{{ $verification_url }}">clicking here</a>.
        If the link does not work, you can click the link below or paste it in your address bar.
        <br/>
        <br/>
        <a href="{{ $verification_url }}">{{ $verification_url }}</a>
    </p>
    <p>Kind Regards,</p>
@stop