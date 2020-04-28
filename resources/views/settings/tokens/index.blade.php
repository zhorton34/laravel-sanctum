@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span style="font-size:18px">
                            Your Tokens
                        </span>
                        <a class="btn btn-primary float-right" href="{{ route('settings.tokens.create') }}">
                            Create Token
                        </a>
                    </div>

                    <div class="card-body">
                        <small>(Your Api Tokens Allow You To Access The Api)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @foreach($user->tokens as $token)
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-content-center">
                            <a href="/settings/tokens/{{ $token->id }}/edit">
                                <h4>{{ $token->name }}</h4>
                            </a>

                            <form action="/settings/tokens/{{ $token->id }}" method="POST">
                                @method('delete')
                                @csrf

                                <input type="hidden" name="id" value="{{ $token->id }}" />

                                <button class="btn btn-outline-danger">
                                    Revoke Token
                                </button>
                            </form>
                        </div>

                        <div class="card-body">
                            {{ implode(', ', $token->abilities) }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
