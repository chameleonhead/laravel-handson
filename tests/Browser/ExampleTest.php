<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('Laravel');
        });
    }

    /**
     * My test implementation
     */
    public function testLogin()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use($user) {
            $browser->visit('/login');
            $browser->type('email', $user->email);
            $browser->type('password', 'password');
            $browser->check('remember');
            $browser->press('Login');
            $browser->assertPathIs('/dashboard');
        });
    }
}
