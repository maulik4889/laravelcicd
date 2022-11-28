<?php

return [

    /*
     * Stripe will sign each webhook using a secret. You can find the used secret at the
     * webhook configuration settings: https://dashboard.stripe.com/account/webhooks.
     */
// secret for when Stripe posts to webhook-url/account
'signing_secret_account' => 'whsec_OThkBiEUmYgPCSWdTWGYc30vQgmKKGho',
// secret for when Stripe posts to webhook-url/connect
'signing_secret_connect' => 'whsec_56tcq93qznlxlU7MLFr3PFTPqRmy9LRq',
    /*
     * You can define the job that should be run when a certain webhook hits your application
     * here. The key is the name of the Stripe event type with the `.` replaced by a `_`.
     *
     * You can find a list of Stripe webhook types here:
     * https://stripe.com/docs/api#event_types.
     */
    'jobs' => [
        // 'source_chargeable' => \App\Jobs\StripeWebhooks\HandleChargeableSource::class,
        // 'charge_failed' => \App\Jobs\StripeWebhooks\HandleFailedCharge::class,
                'payment_intent_succeeded' => \App\Jobs\StripeWebhooks\ChargeSucceededJob::class,
                'transfer_created' => \App\Jobs\StripeWebhooks\ChargeSucceededJob::class,
                'transfer_paid' => \App\Jobs\StripeWebhooks\ChargeSucceededJob::class,
                'account_updated' => \App\Jobs\StripeWebhooks\ChargeSucceededJob::class,

    ],

    /*
     * The classname of the model to be used. The class should equal or extend
     * Spatie\StripeWebhooks\ProcessStripeWebhookJob.
     */
    'model' => \Spatie\StripeWebhooks\ProcessStripeWebhookJob::class,
];
