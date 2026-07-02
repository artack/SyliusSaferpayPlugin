<?php

declare(strict_types=1);

namespace CommerceWeavers\SyliusSaferpayPlugin\Payment\EventListener;

use CommerceWeavers\SyliusSaferpayPlugin\Processor\RefundProcessorInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Symfony\Component\Workflow\Event\TransitionEvent;
use Webmozart\Assert\Assert;

final class RefundPaymentOnTransitionListener
{
    public function __construct(private RefundProcessorInterface $refundProcessor)
    {
    }

    public function __invoke(TransitionEvent $event): void
    {
        $payment = $event->getSubject();
        Assert::isInstanceOf($payment, PaymentInterface::class);

        $this->refundProcessor->process($payment);
    }
}
