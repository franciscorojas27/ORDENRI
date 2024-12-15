<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Database\Factories\UserFactory;

class ExampleDuskTest extends DuskTestCase
{
    public function test_Login()
    {
        $user = UserFactory::new()->create();
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('userid', $user->userid)
                ->type('password', 'password')
                ->press('#Login')  // Busca el botón por su ID
                ->assertPathIs('/orders');
        });
    }
}
