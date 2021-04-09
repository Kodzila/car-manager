<?php

declare(strict_types=1);

namespace Kodzila\Tests\E2E\Util;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Psr\Container\ContainerInterface;
use Webmozart\Assert\Assert;

final class ApiClient
{
    private ?string $jwt = null;

    public function __construct(private Client $client)
    {
    }

    public function post(string $url, array $jsonData): ApiResponse
    {
        $options = ['json' => $jsonData];

        $options = $this->appendAuthHeaders($options);

        $result = $this->client->request('POST', $url, $options);
        return new ApiResponse($result);
    }

    public function delete(string $url): ApiResponse
    {
        $options = $this->appendAuthHeaders([]);

        $result = $this->client->request('DELETE', $url, $options);
        return new ApiResponse($result);
    }

    public function patch(string $url, array $jsonData): ApiResponse
    {
        $options = [
            'json' => $jsonData,
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ],
        ];

        $options = $this->appendAuthHeaders($options);

        $result = $this->client->request('PATCH', $url, $options);

        return new ApiResponse($result);
    }

    public function get(string $url, string $contentType = 'application/ld+json'): ApiResponse
    {
        $options = $this->appendAuthHeaders([]);
        $options['headers']['accept'] = $contentType;

        $response = $this->client->request('GET', $url, $options);

        return new ApiResponse($response);
    }

    public function getBinaryApiResource(string $url): ApiResponse
    {
        $response = $this->client->request('GET', $url);
        Assert::eq($response->getStatusCode(), 200);

        return new ApiResponse($response);
    }

    public function container(): ContainerInterface
    {
        $container = $this->client->getContainer();
        Assert::notNull($container);

        return $container;
    }

    public function setJwt(?string $jwt): void
    {
        $this->jwt = $jwt;
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnTypeCoercion
     * @return array<array-key,string[]|string>
     */
    public function getDecodedDataFromJwtToken(): array
    {
        $encoder = $this->container()->get('test_jwt_encoder');

        Assert::notNull($encoder);
        Assert::isInstanceOf($encoder, JWTEncoderInterface::class);
        Assert::notNull($this->jwt);

        return $encoder->decode($this->jwt);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    private function appendAuthHeaders(array $options): array
    {
        if ($this->jwt) {
            $options['headers']['Authorization'] = 'Bearer ' . $this->jwt;
        }

        return $options;
    }
}
