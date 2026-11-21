# CloakMotion highlights

Excerpts from CloakMotion, a multi-tenant AI video SaaS I built (Laravel 10 API with Cashier, a Next.js frontend and a separate
Python FastAPI service that does the video work). The full repo is private; these are the parts the blog posts talk about.
They are excerpts, not a runnable app.

| Folder | What it shows | Blog post |
|---|---|---|
| `stripe/` | A webhook guard that refuses to boot without `STRIPE_WEBHOOK_SECRET`, and a Stripe billing portal configured so a plan change cannot downgrade a paying user | [Two Stripe bugs I found auditing my own SaaS](https://hassanabbas.net/blog/stripe-webhooks-and-portal.html) |
| `gating/` | A free plan that cannot render: the server checks for an active subscription before any paid action | [A free tier that can't spend your AI budget](https://hassanabbas.net/blog/free-tier-that-cannot-spend.html) |
| `video-service/` | Timeouts on every outbound call and ffmpeg command, routes that do not block the event loop, and a failed GPT call handled before it is used | [Making a video service fail properly](https://hassanabbas.net/blog/video-service-timeouts.html) |

CloakMotion has no automated test suite and is not deployed publicly. It runs locally in Docker and is shown through a recorded
walkthrough in my Upwork portfolio.
