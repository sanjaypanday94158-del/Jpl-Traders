<?php

namespace Tests\Feature;

use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_the_newsletter_subscription_form(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('NEWSLETTER SUBSCRIPTION')
            ->assertSee('Get updates on new products, useful offers, and IT tips from JPL Traders.')
            ->assertSee('I agree to receive JPL product updates, offers, and IT tips by email.');
    }

    public function test_a_visitor_can_subscribe_with_explicit_consent(): void
    {
        $this->from(route('home'))
            ->post(route('newsletter.subscribe'), [
                'email' => 'Customer@Example.com',
                'consent' => '1',
            ])
            ->assertRedirect(route('home'))
            ->assertSessionHas('newsletter_status', "You're subscribed to JPL updates. Thank you!");

        $subscriber = NewsletterSubscriber::firstOrFail();

        $this->assertSame('customer@example.com', $subscriber->email);
        $this->assertNotNull($subscriber->consented_at);
    }

    public function test_duplicate_subscriptions_are_not_stored_twice(): void
    {
        NewsletterSubscriber::create([
            'email' => 'customer@example.com',
            'consented_at' => now(),
        ]);

        $this->from(route('home'))
            ->post(route('newsletter.subscribe'), [
                'email' => 'CUSTOMER@example.com',
                'consent' => '1',
            ])
            ->assertRedirect(route('home'))
            ->assertSessionHas('newsletter_status', 'This email is already subscribed to JPL updates.');

        $this->assertDatabaseCount('newsletter_subscribers', 1);
    }

    public function test_invalid_email_or_missing_consent_cannot_subscribe(): void
    {
        $this->from(route('home'))
            ->post(route('newsletter.subscribe'), [
                'email' => 'not-an-email',
            ])
            ->assertRedirect(route('home'))
            ->assertSessionHasErrors(['email', 'consent'], null, 'newsletter');

        $this->assertDatabaseCount('newsletter_subscribers', 0);
    }
}
