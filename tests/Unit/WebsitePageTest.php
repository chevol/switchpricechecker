<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebsitePageTest extends TestCase
{
    /**
     * A basic unit test of the games listing page.
     *
     * @return void
     */
    public function testGamesListingPage()
    {
      $response = $this->get('games');

      $response->assertStatus(200);
    }
}
