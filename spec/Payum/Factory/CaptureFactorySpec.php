<?php

declare(strict_types=1);

namespace spec\CommerceWeavers\SyliusSaferpayPlugin\Payum\Factory;

use CommerceWeavers\SyliusSaferpayPlugin\Payum\Factory\CaptureFactoryInterface;
use Payum\Core\Request\Capture;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\PaymentInterface;

final class CaptureFactorySpec extends ObjectBehavior
{
    public function it_implements_capture_factory_interface(): void
    {
        $this->shouldImplement(CaptureFactoryInterface::class);
    }

    public function it_creates_new_capture_request(PaymentInterface $payment): void
    {
        $this->createNewWithModel($payment->getWrappedObject())->shouldBeLike(new Capture($payment->getWrappedObject()));
    }
}
