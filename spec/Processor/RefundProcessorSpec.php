<?php

declare(strict_types=1);

namespace spec\CommerceWeavers\SyliusSaferpayPlugin\Processor;

use CommerceWeavers\SyliusSaferpayPlugin\Payum\Factory\RefundFactoryInterface;
use CommerceWeavers\SyliusSaferpayPlugin\Payum\Provider\TokenProviderInterface;
use CommerceWeavers\SyliusSaferpayPlugin\Payum\Request\RefundInterface;
use Payum\Core\GatewayInterface;
use Payum\Core\Payum;
use Payum\Core\Request\GetStatusInterface;
use Payum\Core\Security\HttpRequestVerifierInterface;
use Payum\Core\Security\TokenInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\PayumBundle\Factory\GetStatusFactoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;

final class RefundProcessorSpec extends ObjectBehavior
{
    public function let(
        TokenProviderInterface $tokenProvider,
        Payum $payum,
        GetStatusFactoryInterface $getStatusFactory,
        RefundFactoryInterface $refundFactory,
    ): void {
        $this->beConstructedWith($tokenProvider, $payum, $getStatusFactory, $refundFactory);
    }

    public function it_executes_refund_process(
        TokenProviderInterface $tokenProvider,
        Payum $payum,
        GetStatusFactoryInterface $getStatusFactory,
        RefundFactoryInterface $refundFactory,
        HttpRequestVerifierInterface $httpRequestVerifier,
        TokenInterface $token,
        GatewayInterface $gateway,
        GetStatusInterface $getStatus,
        RefundInterface $refund,
        PaymentInterface $payment,
        OrderInterface $order,
    ): void {
        $payment->getOrder()->willReturn($order);
        $order->getId()->willReturn('1');

        $tokenProvider->provide($payment, 'sylius_admin_order_show', ['id' => '1'])->willReturn($token);
        $token->getGatewayName()->willReturn('saferpay');

        $refundFactory->createNewWithModel($token)->willReturn($refund->getWrappedObject());
        $refund->getFirstModel()->willReturn($payment);

        $getStatusFactory->createNewWithModel($payment)->willReturn($getStatus);

        $payum->getGateway('saferpay')->willReturn($gateway);
        $gateway->execute($refund)->shouldBeCalled();
        $gateway->execute($getStatus)->shouldBeCalled()->willReturn($getStatus);

        $payum->getHttpRequestVerifier()->willReturn($httpRequestVerifier);
        $httpRequestVerifier->invalidate($token)->shouldBeCalled();

        $this->process($payment);
    }

    public function it_throws_an_exception_if_order_is_null(PaymentInterface $payment): void
    {
        $payment->getOrder()->willReturn(null);

        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('process', [$payment])
        ;
    }
}
