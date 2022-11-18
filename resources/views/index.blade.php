@extends('main/main')
@section('title','Dashboard')
@section('content')
    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @guest
                            {{ __('Silahkan login/register') }}
                        @else
                            {{ __('You are logged in!') }}
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection