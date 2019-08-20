<?php

namespace App\Http\Controllers;

use App\Model\Game;
use Illuminate\Http\Request;
use function hash;

class GameController extends Controller
{
    /**
     * Handle a initialize request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function initialize(Request $request)
    {
        $this->validateInitialize($request);

        if ($this->attemptInitialize($request)) {
            return $this->sendInitializeResponse($request);
        }
        return $this->sendFailedInitializeResponse($request);
    }

    /**
     * Validate the initialize request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateInitialize(Request $request)
    {
        $request->validate([
            'app_id' => 'required|string|max:255',
            'sign' => 'required|string|max:255'
        ]);
    }
    /**
     * Attempt to initialize an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptInitialize(Request $request)
    {
        $game = Game::findOrFail($request->get("app_id"));

        return hash('sha256', $app_id.$game->app_key) == $request->get("sign");
    }

    /**
     * Send the response after the order was initialized.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Order  $order
     * 
     * @return \Illuminate\Http\Response
     */
    protected function sendInitializeResponse(Request $request, $order)
    {
        return response()->json([
            'order_id' => $order->id,
            'currency' => $order->currency,
            'amount' => $order->amount
        ]);
    }

    /**
     * Get the failed initialize response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedInitializeResponse(Request $request)
    {
        return response()->json([
            'message' => trans('failed'),
            'status_code' => 500
        ], 500);
    }
}
