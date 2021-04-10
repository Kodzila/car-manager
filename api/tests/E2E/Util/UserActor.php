<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E\Util;

final class UserActor
{
    public function __construct(
        private ApiClient $apiClient,
        private string $email,
        private string $password,
        private string $iri,
    ) {
    }

    public function login(): void
    {
        $res = $this->apiClient->post('/api/auth/token', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $jwt = $res->getToken()->token;
        $this->apiClient->setJwt($jwt);
    }

    public function getIri(): string
    {
        return $this->iri;
    }
}
