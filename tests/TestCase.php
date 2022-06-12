<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function post($uri, array $data = [], array $headers = [])
    {
        return parent::post($uri, $data, array_merge(['Accept' => 'application/json'], $headers));
    }
}
