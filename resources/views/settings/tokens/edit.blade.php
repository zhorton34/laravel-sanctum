@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Showing {{ $token->name }} Token</div>

                    <div class="card-body">
                        <form method="POST" action="/settings/tokens/{{ $token->id }}">
                            @csrf
                            @method('put')

                            <input type="hidden" name='id' value="{{ $token->id }}" />

                            <label>Token Name</label>
                            <input
                                type="text"
                                name="token_name"
                                class='form-control'
                                placeholder="Ex: 'ExampleMobileApp Token'"
                                value="{{ $token->name }}"
                            />
                            @error('token_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <hr>

                            @foreach (config('sanctum.abilities') as $name => $description)
                                @if (is_array($description))
                                    <hr>
                                    <strong>
                                        {{ ucwords($name) }} Rules
                                    </strong>
                                    <hr>
                                    @foreach ($description as $ability_name => $ability_description)
                                        <div class="w-100 ml-3">
                                            <input type="checkbox" name="ability[{{ $ability_name }}]" value="{{ $ability_name }}" {{ $token->can($ability_name) ? 'checked' : '' }} />
                                            @error('ability.' . $ability_name)
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <label class="ml-2">{{ $ability_name }}</label>
                                            <small class="ml-2">({{ $ability_description }})</small>
                                        </div>
                                    @endforeach
                                    <hr>
                                @else
                                    <div class="w-100">
                                        <input type="checkbox" name="ability[{{ $name }}]" value="{{ $name }}" {{ $token->can($name) ? 'checked' : '' }}/>
                                        @error('ability.' . $name)
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <label class="ml-2">{{ $name }}</label>
                                        <small class="ml-2">({{ $description }})</small>
                                    </div>
                                @endif
                            @endforeach

                            <button class="btn btn-primary" type="submit">
                                Update Token
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
