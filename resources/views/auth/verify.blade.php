@extends('layouts.app')

@section('content')
    <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('Verifica tu dirección email') }}</p>

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('Se envió a tu correo un link de verficación') }}
            </div>
        @endif

        {{ __('Antes de continuar, comprueba tu correo para enviar el link de verficación') }}
        {{ __('Si tú no recibiste el correo de verificación') }},
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <div class="row">
                <div class="col-12">
                    <button type="submit"
                            class="btn btn-primary btn-block">{{ __('click aquí para reenviar el link') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
