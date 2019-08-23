<?php

namespace App\Http\Controllers;

use App\Model\Game;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

class UserController extends Controller
{
    /**
     * The encryption key.
     *
     * @var callable
     */
    protected $key;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }

    /**
     * Handle a verify request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verify(Request $request)
    {
        $request->validate([
            'app_id' => 'required|string|max:255',
            'signature' => 'required|string|max:255'
        ]);
        $app = Game::findOrFail($request->input('app_id'));
        // Set encryption key
        $this->key = $app->secret;

        if (!$this->hasValidSignature($request))
            throw new InvalidSignatureException;
        return response()->json([
            'openid' => $request->user()->openid
        ], 200);
    }

    /**
     * Determine if the given request has a valid signature.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasValidSignature(Request $request)
    {
        $original = collect($request->except('signature'))->sortKeys()->implode('&');        
        $signature = hash_hmac('sha256', $original, $this->key);

        return  hash_equals($signature, (string) $request->input('signature', ''));
    }
}
