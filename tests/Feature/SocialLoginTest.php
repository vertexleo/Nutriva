<?php

namespace Tests\Feature;

use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class SocialLoginTest extends TestCase
{
    public function test_google_redirects_to_provider_auth_page(): void
    {
        $driver = Mockery::mock();
        $driver->shouldReceive('redirect')->once()->andReturn(new RedirectResponse('https://accounts.google.com/o/oauth2/auth'));

        Socialite::shouldReceive('driver')->once()->with('google')->andReturn($driver);

        $response = $this->get(route('social.redirect', ['provider' => 'google']));

        $response->assertRedirect('https://accounts.google.com/o/oauth2/auth');
    }
}
