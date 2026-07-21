<?php

declare(strict_types=1);

namespace spec\CommerceWeavers\SyliusSaferpayPlugin\Provider;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class OrderProviderSpec extends ObjectBehavior
{
    public function let(OrderRepositoryInterface $orderRepository): void
    {
        $this->beConstructedWith($orderRepository);
    }

    public function it_throws_an_exception_when_order_with_given_token_does_not_exist_for_assert(
        OrderRepositoryInterface $orderRepository,
    ): void {
        $orderRepository->findOneByTokenValue('TOKEN')->willReturn(null);

        $this
            ->shouldThrow(new NotFoundHttpException('Order with token "TOKEN" does not exist.'))
            ->during('provideForAssert', ['TOKEN'])
        ;
    }

    public function it_throws_an_exception_when_order_with_given_token_does_not_exist_for_capture(
        OrderRepositoryInterface $orderRepository,
    ): void {
        $orderRepository->findOneByTokenValue('TOKEN')->willReturn(null);

        $this
            ->shouldThrow(new NotFoundHttpException('Order with token "TOKEN" does not exist.'))
            ->during('provideForCapture', ['TOKEN'])
        ;
    }

    public function it_provides_order_for_assert(
        OrderRepositoryInterface $orderRepository,
        OrderInterface $order,
    ): void {
        $orderRepository->findOneByTokenValue('TOKEN')->willReturn($order);

        $this->provideForAssert('TOKEN')->shouldReturn($order);
    }

    public function it_provides_order_for_capture(
        OrderRepositoryInterface $orderRepository,
        OrderInterface $order,
    ): void {
        $orderRepository->findOneByTokenValue('TOKEN')->willReturn($order);

        $this->provideForCapture('TOKEN')->shouldReturn($order);
    }
}
