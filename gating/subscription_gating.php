<?php
// The free plan cannot render, so free sign-ups cannot spend the AI budget.
// The rule lives on the server, in one place (app/Models/User.php).

public function isSubscribed(): bool
{
    return $this->subscribed('starter') ||
        $this->subscribed('daily') ||
        $this->subscribed('hardcore');
}

// The number of series a user can run comes from the subscription quantity.
// Free (unsubscribed) users get 0: the free tier does not render or burn API spend at all.
public function maxSeries(): int
{
    return (int) ($this->activeSubscription()?->quantity ?? 0);
}

// Paid actions start with the same guard (VideoController, ToolsController, ...):
if (! $request->user()->isSubscribed()) {
    return response()->json([
        'message' => 'An active subscription is required to re-render a video.',
    ], 403);
}

// The scheduler only dispatches the YouTube and TikTok uploads if the user is still subscribed
// (ProcessScheduledVideosJob):
if ($video->user->isSubscribed()) {
    // dispatch the TikTok and YouTube upload jobs for the series' linked accounts
}
