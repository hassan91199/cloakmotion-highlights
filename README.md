# Stripe billing audit examples

Two small fixes from a security and payment audit of CloakMotion, a multi-tenant AI video SaaS I built (Laravel 10 API, Cashier, Next.js frontend).
These are excerpts, not a runnable app. The full write-up is on my portfolio site.

| File | Problem found | Fix |
|---|---|---|
| `webhook_secret_guard.php` | The Stripe webhook accepts forged events if `STRIPE_WEBHOOK_SECRET` is not set | The app refuses to boot in production without it |
| `restricted_portal_config.php` | A plan change in the Stripe portal created a subscription with no plan name, so a paying customer was treated as free | The portal is created with plan changes disabled; plan changes go through the app's own endpoint |

CloakMotion has no automated test suite and is not deployed publicly.
