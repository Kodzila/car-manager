<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E\Util;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;

final class ApiResponse
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function assertSuccess(bool $attachMessage = false): self
    {
        if (! in_array($this->response->getStatusCode(), [200, 201, 202, 204], true)) {
            $message = sprintf(
                'Return code is not successful: %s',
                $this->response->getStatusCode(),
            );

            if ($attachMessage) {
                $message .= sprintf(
                    ' .Content: %s',
                    $this->response->getContent(),
                );
            }

            TestCase::fail($message);
        }

        TestCase::assertTrue(true);

        return $this;
    }

    public function assert4xx(): self
    {
        $code = $this->response->getStatusCode();

        if (substr((string) $code, 0, 1) !== '4') {
            TestCase::fail(sprintf(
                'Expected 4xx return code. Given: %s',
                $code,
            ));
        }

        TestCase::assertTrue(true);

        return $this;
    }

    public function assertCode(int $expectedCode): self
    {
        $code = $this->response->getStatusCode();

        if ($code !== $expectedCode) {
            TestCase::fail(sprintf(
                'Expected %s return code. Given: %s',
                $expectedCode,
                $code,
            ));
        }

        TestCase::assertTrue(true);

        return $this;
    }

    public function getIri(): string
    {
        $this->assertSuccess();
        $iri = $this->json()['@id'];
        Assert::string($iri);
        return $iri;
    }

    public function getId(): string
    {
        $this->assertSuccess();
        $id = $this->json()['id'];
        Assert::string($id);
        return $id;
    }

    public function getToken(): Token
    {
        $this->assertSuccess();
        $jwt = $this->json()['token'];
        Assert::string($jwt);
        return new Token($jwt);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return array<string, mixed>
     */
    public function contentData(): array
    {
        $this->assertSuccess();
        $json = $this->json();
        $result = [];

        foreach ($json as $key => $value) {
            Assert::string($key);
            $result[$key] = $value;
        }

        return $result;
    }

    public function content(): string
    {
        $this->assertSuccess();
        return $this->response->getContent();
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    public function getHydraMembers(): array
    {
        $members = $this->json()['hydra:member'];
        Assert::isArray($members);

        return $members;
    }

    public function getHydraTotalItemsCount(): int
    {
        $this->assertSuccess();
        return (int) $this->json()['hydra:totalItems'];
    }

    /**
     * @param string $name
     * @return array<array-key, string>
     */
    public function getResponseHeader(string $name): array
    {
        $headers = $this->response->getHeaders();
        Assert::keyExists($headers, $name);

        return $headers[$name];
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    private function json(): array
    {
        $content = $this->response->getContent();
        $json = json_decode($content, true);
        Assert::isArray($json);

        return $json;
    }
}
