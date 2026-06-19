<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook as StripeWebhook;
use Stripe\Exception\SignatureVerificationException;
use App\Models\Payment;
use App\Models\Webhook;
use Illuminate\Support\Facades\Log;
use App\Services\PaymentService;

class StripeWebhookController extends Controller
{
    protected $paymentService;


    public function __construct(
        PaymentService $paymentService
    ) {
        $this->paymentService = $paymentService;
    }


    public function handle(Request $request)
    {

        /*
        GET RAW STRIPE DATA
        */

        $payload = $request->getContent();

        $signature = $request->header('Stripe-Signature');

        $webhookSecret = env('STRIPE_WEBHOOK_SECRET');


        /*
        VERIFY STRIPE SIGNATURE
        */

        try {

            $event = StripeWebhook::constructEvent(
                $payload,
                $signature,
                $webhookSecret
            );


        } catch (SignatureVerificationException $e) {


            Log::error('Stripe Signature Verification Failed', [

                'message'=>$e->getMessage()

            ]);


            return response()->json([

                'error'=>'Invalid Stripe signature'

            ],400);



        } catch (\Exception $e) {


            Log::error('Stripe Webhook Error',[

                'message'=>$e->getMessage()

            ]);


            return response()->json([

                'error'=>'Webhook processing failed'

            ],500);

        }



        /*
        PREVENT DUPLICATE WEBHOOK
        */


        $existingWebhook = Webhook::where(
            'event_id',
            $event->id
        )->first();



        if($existingWebhook){

            return response()->json([

                'message'=>'Webhook already processed'

            ]);

        }



        /*
        STORE WEBHOOK EVENT
        */


        Webhook::create([

            'event_id'=>$event->id,

            'event_type'=>$event->type,

            'stripe_object_id'=>
                $event->data->object->id ?? null,

            'payload'=>json_decode($payload,true),

            'status'=>'processed'

        ]);




        /*
        HANDLE STRIPE EVENTS
        */


        switch($event->type){



            /*
            CHECKOUT CREATED COMPLETED
            */

            case 'checkout.session.completed':


                $session = $event->data->object;


                Payment::where(
                    'stripe_session_id',
                    $session->id
                )->update([

                    'status'=>'checkout_completed'

                ]);



            break;



            /*
            PAYMENT SUCCESS
            */


            case 'payment_intent.succeeded':



                $paymentIntent = $event->data->object;



                $payment = Payment::where(

                    'id',

                    $paymentIntent->metadata->payment_id ?? null

                )->first();



                if($payment){


                    /*
                    This updates:
                    payment = paid
                    booking = completed/payment
                    */

                    $this->paymentService
                        ->markAsPaid($payment);

                }



            break;




            /*
            PAYMENT FAILED
            */


            case 'payment_intent.payment_failed':


                $paymentIntent = $event->data->object;



                Payment::where(

                    'id',

                    $paymentIntent->metadata->payment_id ?? null

                )->update([


                    'status'=>'failed'


                ]);



            break;




            /*
            CHECKOUT EXPIRED
            */


            case 'checkout.session.expired':


                $session = $event->data->object;



                Payment::where(

                    'stripe_session_id',

                    $session->id

                )->update([


                    'status'=>'expired'


                ]);



            break;


        }




        return response()->json([

            'success'=>true

        ]);

    }
}