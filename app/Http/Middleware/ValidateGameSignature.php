<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Game;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

class ValidateGameSignature
{
    /**
     * The encryption key.
     *
     * @var callable
     */
    protected $key;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->hasValidAppId($request) 
            && $this->hasValidSignature($request)) {
            return $next($request);
        }

        throw new InvalidSignatureException;
    }

    /**
     * Determine if the given request has a valid app_id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasValidAppId(Request $request)
    {
        $app = Game::findOrFail($request->input('app_id'));
        // Set encryption key
        $this->key = $app->key;
        
        return true;
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
