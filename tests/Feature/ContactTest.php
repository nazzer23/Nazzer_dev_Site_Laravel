<?php

namespace Tests\Feature;

use App\Livewire\Contact;
use App\Mail\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        RateLimiter::clear('contact-form:127.0.0.1');
    }

    public function test_name_email_and_message_are_required(): void
    {
        Mail::fake();

        Livewire::test(Contact::class)
            ->set('name', '')
            ->set('email', '')
            ->set('message', '')
            ->call('send')
            ->assertHasErrors(['name' => 'required', 'email' => 'required', 'message' => 'required']);

        Mail::assertNothingSent();
    }

    public function test_email_must_be_valid(): void
    {
        Mail::fake();

        Livewire::test(Contact::class)
            ->set('name', 'Ben')
            ->set('email', 'not-an-email')
            ->set('message', 'This is a valid length message.')
            ->call('send')
            ->assertHasErrors(['email' => 'email']);

        Mail::assertNothingSent();
    }

    public function test_message_must_be_at_least_ten_characters(): void
    {
        Mail::fake();

        Livewire::test(Contact::class)
            ->set('name', 'Ben')
            ->set('email', 'ben@example.com')
            ->set('message', 'too short')
            ->call('send')
            ->assertHasErrors(['message' => 'min']);

        Mail::assertNothingSent();
    }

    public function test_message_must_not_exceed_five_thousand_characters(): void
    {
        Mail::fake();

        Livewire::test(Contact::class)
            ->set('name', 'Ben')
            ->set('email', 'ben@example.com')
            ->set('message', str_repeat('a', 5001))
            ->call('send')
            ->assertHasErrors(['message' => 'max']);

        Mail::assertNothingSent();
    }

    public function test_valid_submission_sends_mail_and_marks_as_sent(): void
    {
        Mail::fake();

        $component = Livewire::test(Contact::class)
            ->set('name', 'Ben')
            ->set('email', 'ben@example.com')
            ->set('message', 'This is a valid length message.')
            ->call('send');

        $component->assertHasNoErrors();
        $component->assertSet('sent', true);
        $component->assertSet('name', '');
        $component->assertSet('email', '');
        $component->assertSet('message', '');

        Mail::assertSent(ContactMessage::class, function (ContactMessage $mail) {
            return $mail->senderName === 'Ben'
                && $mail->senderEmail === 'ben@example.com'
                && $mail->body === 'This is a valid length message.';
        });
    }

    public function test_honeypot_field_silently_succeeds_without_sending_mail(): void
    {
        Mail::fake();

        $component = Livewire::test(Contact::class)
            ->set('name', 'Ben')
            ->set('email', 'ben@example.com')
            ->set('message', 'This is a valid length message.')
            ->set('website', 'https://spambot.example.com')
            ->call('send');

        $component->assertHasNoErrors();
        $component->assertSet('sent', true);

        Mail::assertNothingSent();
    }

    public function test_rate_limit_blocks_further_submissions_after_max_attempts(): void
    {
        Mail::fake();

        for ($i = 0; $i < 3; $i++) {
            Livewire::test(Contact::class)
                ->set('name', 'Ben')
                ->set('email', 'ben@example.com')
                ->set('message', 'This is a valid length message.')
                ->call('send');
        }

        Mail::assertSentCount(3);

        Livewire::test(Contact::class)
            ->set('name', 'Ben')
            ->set('email', 'ben@example.com')
            ->set('message', 'This is a valid length message.')
            ->call('send')
            ->assertHasErrors(['message']);

        Mail::assertSentCount(3);
    }
}
