<?php

declare(strict_types=1);

namespace spec\CommerceWeavers\SyliusSaferpayPlugin\Controller\Action;

use CommerceWeavers\SyliusSaferpayPlugin\Provider\OrderProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class AfterUnsuccessfulPaymentActionSpec extends ObjectBehavior
{
    public function let(
        OrderProviderInterface $orderProvider,
        UrlGeneratorInterface $router,
    ): void {
        $this->beConstructedWith($orderProvider, $router);
    }

    public function it_redirects_to_order_show_page_if_last_payment_is_new(
        OrderProviderInterface $orderProvider,
        UrlGeneratorInterface $router,
        Request $request,
        OrderInterface $order,
        PaymentInterface $lastPayment,
        PaymentInterface $penultimatePayment,
        Session $session,
        FlashBagInterface $flashBag,
    ): void {
        $orderProvider->provide('TOKEN')->willReturn($order);
        $order->getPayments()->willReturn(new ArrayCollection([
            $penultimatePayment->getWrappedObject(),
            $lastPayment->getWrappedObject(),
        ]));

        $lastPayment->getState()->willReturn(PaymentInterface::STATE_NEW);
        $penultimatePayment->getState()->willReturn(PaymentInterface::STATE_CANCELLED);

        $request->getSession()->willReturn($session);
        $session->getFlashBag()->willReturn($flashBag);
        $flashBag->add('info', 'sylius.payment.cancelled')->shouldBeCalled();

        $router->generate('sylius_shop_order_show', ['tokenValue' => 'TOKEN'])->willReturn('/orders/TOKEN');

        $this($request, 'TOKEN')->shouldBeLike(new RedirectResponse('/orders/TOKEN'));
    }

    public function it_redirects_to_thank_you_page_if_last_payment_is_not_new(
        OrderProviderInterface $orderProvider,
        UrlGeneratorInterface $router,
        Request $request,
        OrderInterface $order,
        PaymentInterface $lastPayment,
        PaymentInterface $penultimatePayment,
        Session $session,
        FlashBagInterface $flashBag,
    ): void {
        $orderProvider->provide('TOKEN')->willReturn($order);
        $order->getPayments()->willReturn(new ArrayCollection([
            $penultimatePayment->getWrappedObject(),
            $lastPayment->getWrappedObject(),
        ]));

        $lastPayment->getState()->willReturn(PaymentInterface::STATE_COMPLETED);

        $request->getSession()->willReturn($session);
        $session->getFlashBag()->willReturn($flashBag);
        $flashBag->add('info', 'sylius.payment.completed')->shouldBeCalled();

        $router->generate('sylius_shop_order_thank_you')->willReturn('/thank-you');

        $this($request, 'TOKEN')->shouldBeLike(new RedirectResponse('/thank-you'));
    }
}
