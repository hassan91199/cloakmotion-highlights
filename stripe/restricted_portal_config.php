<?php
// A subscription changed inside the Stripe customer portal carries no plan metadata, so the app
// stored it with type 'default' and its access checks treated a paying customer as free.
// Plan changes go through the app's own /billing/subscribe endpoint, which sets the plan.
// The portal configuration is created once with plan changes turned off and cached.

use Illuminate\Support\Facades\Cache;
use Stripe\BillingPortal\Configuration;

private function restrictedPortalConfigurationId(): string
{
    return Cache::rememberForever('stripe.portal_configuration_id', function () {
        return Configuration::create([
            'business_profile' => ['headline' => config('app.name') . ' billing'],
            'features' => [
                'customer_update' => ['enabled' => true, 'allowed_updates' => ['email', 'address']],
                'invoice_history' => ['enabled' => true],
                'payment_method_update' => ['enabled' => true],
                'subscription_cancel' => ['enabled' => true],
                'subscription_update' => ['enabled' => false],
            ],
        ])->id;
    });
}
