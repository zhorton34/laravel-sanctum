<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSanctumToken;
use App\Http\Requests\UpdateSanctumToken;

class TokensController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        return view('settings.tokens.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.tokens.create');
    }

    public function store(StoreSanctumToken $request)
    {
        $user = auth()->user();
        $name = $request->input('token_name');
        $abilities = $request->input('ability');

        $user->createToken($name, $abilities);

        return redirect(route('settings.tokens.index'));
    }

    public function edit($id)
    {
        $user = auth()->user();
        $token = $user->tokens()->where('id', $id)->first();

        return view('settings.tokens.edit', compact('user', 'token'));
    }

    public function update(UpdateSanctumToken $request, $id)
    {
        $user = auth()->user();
        $token = $user->tokens()->where('id', $id)->first();

        $token->name = $request->input('token_name');
        $token->abilities = $request->input('ability.*');

        $token->save();

        return redirect(route('settings.tokens.index'));
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $user->tokens()->where('id', $id)->delete();

        return redirect(route('settings.tokens.index'));
    }
}
