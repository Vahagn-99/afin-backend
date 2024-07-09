<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\HasAuthUser;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function shouldSeed(): true
    {
        return true;
    }

    protected function setUpTraits(): array
    {
        $uses = parent::setUpTraits();

        if (isset($uses[HasAuthUser::class])) {
            $this->authUser();
        }

        return $uses;
    }
}
