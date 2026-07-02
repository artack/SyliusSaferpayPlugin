<?php

declare(strict_types=1);

namespace CommerceWeavers\SyliusSaferpayPlugin\Exception;

final class SaferpayPaymentMethodsUnavailableException extends \RuntimeException
{
    public function __construct(private string $reason)
    {
        parent::__construct(sprintf('Could not retrieve the payment methods from Saferpay: %s', $reason));
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}
