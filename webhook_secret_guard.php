<?php
// Laravel Cashier only verifies the Stripe webhook signature when a webhook secret is set.
// Without one, POST /stripe/webhook accepts forged payloads. Refuse to boot in production
// instead of silently running unsigned. Lives in AppServiceProvider::boot().

public function boot(): void
{
    if ($this->app->environment('production') && empty(config('cashier.webhook.secret'))) {
        throw new \RuntimeException('STRIPE_WEBHOOK_SECRET must be set in production.');
    }
}
