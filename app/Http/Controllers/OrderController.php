<?php

namespace App\Http\Controllers;

use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['pay']]);
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
     * Handle a create request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validateCreate($request);

        if ($order = $this->attemptCreate($request)) {
            return $this->sendCreateResponse($request, $order);
        }
        return $this->sendFailedCreateResponse($request);
    }

    /**
     * Handle a pay request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function pay(Request $request)
    {
        $this->validatePay($request);

        if ($this->attemptPay($request)) {
            return $this->sendPayResponse($request);
        }
        // Call back to game
        $this->callbackToGame($order);

        return $this->sendFailedPayResponse($request);
    }

    /**
     * Validate the order create request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateCreate(Request $request)
    {
        $request->validate([
            'app_id' => 'required|string|max:255',
            'product_id' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'cp_order_id' => 'nullable|string|max:255',
            'callback_url' => 'nullable|string|max:255',
            'callback_info' => 'nullable|string|max:255',
        ]);
    }    

    /**
     * Validate the pay request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validatePay(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string|max:255'
        ]);
    }
    
    /**
     * Attempt to create an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Model\Order  $order
     */
    protected function attemptCreate(Request $request)
    {
        $user = $request->user();

        $data = $request->all();
        $order = Order::create([
            'currency' => 'CNY',
            'amount' => $data['amount'],
            'game_id' => $data['app_id'],
            'user_id' => $user->id,
            'product_id' => $data['product_id'],
            'product_name' => $data['product_name'],
            'cp_order_id' => $data['cp_order_id'],
            'callback_url' => $data['callback_url'],
            'callback_info' => $data['callback_info'],
        ]);
        return $order;
    }

    /**
     * Attempt to pay the order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptPay(Request $request)
    {
        $id = $request->get('order_id');

        $order = Order::findOrFail($id);
        $order->state = 1;
        $order->save();

        return true;
    }

    /**
     * Send the response after the order was created.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Order  $order
     * 
     * @return \Illuminate\Http\Response
     */
    protected function sendCreateResponse(Request $request, $order)
    {
        return response()->json([
            'order_id' => $order->id,
            'currency' => $order->currency,
            'amount' => $order->amount
        ]);
    }

    /**
     * Get the failed create response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedCreateResponse(Request $request)
    {
        return response()->json([
            'message' => trans('failed'),
            'status_code' => 500
        ], 500);
    }

    /**
     * Call back to game order finish.
     *
     * @param  \App\Model\Order  $order
     * @return void
     */
    protected function callbackToGame($order)
    {
        // TODO：通知游戏服务器
    }

    /**
     * Send the response after the order was payed.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    protected function sendPayResponse(Request $request)
    {
        return response()->json([
            'message' => trans('success')
        ], 200);
    }
    
    /**
     * Get the failed pay response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedPayResponse(Request $request)
    {
        return response()->json([
            'message' => trans('failed'),
            'status_code' => 500
        ], 500);
    }
}
