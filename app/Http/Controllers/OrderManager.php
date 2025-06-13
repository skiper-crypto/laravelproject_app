<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;
use Stripe\Webhook;
use \UnexpectedValueException;
use \Stripe\Exception\SignatureVerificationException;

class OrderManager extends Controller
{
    function showCheckout(Request $request){
        return view("checkout");
    }
    function checkoutPost(Request $request){
        $request->validate([
            'address' => 'required',
            'pincode' => 'required',
            'phone' => 'required',
        ]);
        $cartItems = DB::table("cart")
            ->join(
                "products",
                "cart.product_id",
                "=",
                "products.id"
            )
            ->select(
                "cart.product_id",
                DB::raw("count(*) as quantity"),
                'products.price',
                'products.title',
            )
            ->where(
                "cart.user_id",
                auth()->id
            )
            ->groupBy(
                "cart.product_id",
                'products.price',
                'products.title',
            )
            ->get();
        if($cartItems->isEmpty()){
            return redirect(route('cart.show'))->with('error', 'Cart is empty');
        }

        $productIds = [];
        $quantities = [];
        $totalPrice = 0;
        $lineItems = [];
        foreach($cartItems as $cartItem){
            $productIds[] = $cartItem->product_id;
            $quantities[] = $cartItem->quantity;
            $totalPrice += $cartItem->price * $cartItem->quantity;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $cartItem->title,
                    ],
                    'unit_amount' => $cartItem->price * 100,
                ],
                'quantity' => $cartItem->quantity,
            ];
        }

        $order = new Orders();
        $order->user_id = auth()->id;
        $order->address = $request->address;
        $order->pincode = $request->pincode;
        $order->phone = $request->phone;
        $order->product_id = json_encode($productIds);
        $order->total_price = $totalPrice;
        $order->quantity = json_encode($quantities);
        if($order->save()){
            DB::table("cart")->where("user_id",auth()->id)->delete();
            $stripe = new StripeClient(config("app.STRIPE_KEY"));

            $checkoutSession = $stripe->checkout->sessions->create([
                'success_url' => route('payment.success',
                ['order_id' => $order->id]),
                'cancel_url' => route('payment.error'),
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'customer_email' => auth()->email,
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);
            return redirect($checkoutSession->url);
        }
        return redirect(route('cart.show'))->with('error', 'Error occurred');
    }
    function paymentError(){
        return "error";
    }
    function paymentSuccess($order_id){
        return "success" . $order_id;
    }

    function webhookStripe(Request $request){
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('app.STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch(UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch(SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;
            $orderId = $session->metadata->order_id;
            $paymentId = $session->payment_intent;
            $order = Orders::find($orderId);
            if($order) {
                $order->payment_id = $paymentId;
                $order->status = 'payment_completed';
                $order->save();
            }
        }

        return response()->json(['status' => 'success']);

    }
function orderHistory() {
    $orders = Orders::where('user_id', auth()->id)->orderBy('id', "DESC")->paginate(5);
        $orders->getCollection()->transform(function($order) {
            $productIds = json_decode($order->product_id, true);
            $quantities = json_decode($order->quantity, true);

            $products = Products::whereIn('id', $productIds)->get();
            $order->product_details = $products->map(function($product) use ($quantities, $productIds) {
                $index = array_search($product->id, $productIds);
                return [
                    'name' => $product->title,
                    'quantity' => $quantities[$index] ?? 0,
                    'price' => $product->price,
                    'slug' => $product->slug,
                    'image' => $product->image,
                ];
            });
            return $order;
        });
    return view('history', compact('orders'));
    }

}
