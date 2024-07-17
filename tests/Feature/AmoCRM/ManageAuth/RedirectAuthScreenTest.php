<?php

namespace Tests\Feature\AmoCRM\ManageAuth;

use App\Modules\AmoCRM\Core\Facades\Amo;
use Tests\TestCase;

class RedirectAuthScreenTest extends TestCase
{
    public function test_admin_can_redirected_to_correct_amocrm_auth_screen_based_on_integration_id_and_redirect_url(): void
    {
        Amo::fake();
        $response = $this->get('/amocrm/auth');
        Amo::assertRedirectedAuthScreen($response);
    }
}