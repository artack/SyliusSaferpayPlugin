<?php

declare(strict_types=1);

namespace CommerceWeavers\SyliusSaferpayPlugin\Provider;

use CommerceWeavers\SyliusSaferpayPlugin\Client\SaferpayClientInterface;
use CommerceWeavers\SyliusSaferpayPlugin\Exception\SaferpayPaymentMethodsUnavailableException;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class SaferpayPaymentMethodsProvider implements SaferpayPaymentMethodsProviderInterface
{
    public function __construct(private SaferpayClientInterface $client)
    {
    }

    public function provide(PaymentMethodInterface $paymentMethod): array
    {
        $gatewayConfig = $paymentMethod->getGatewayConfig();
        Assert::notNull($gatewayConfig);

        $terminal = $this->client->getTerminal($gatewayConfig);

        if ((int) ($terminal['StatusCode'] ?? Response::HTTP_OK) >= Response::HTTP_BAD_REQUEST) {
            throw new SaferpayPaymentMethodsUnavailableException((string) ($terminal['ErrorMessage'] ?? $terminal['error'] ?? 'Unknown error'));
        }

        if (!isset($terminal['PaymentMethods'])) {
            return [];
        }

        /** @var array $paymentMethodsData */
        $paymentMethodsData = $terminal['PaymentMethods'];

        return array_map(
            fn (array $paymentMethodData): mixed => $paymentMethodData['PaymentMethod'],
            $paymentMethodsData,
        );
    }
}
