<?php

declare(strict_types=1);

namespace CommerceWeavers\SyliusSaferpayPlugin\Controller\Action;

use CommerceWeavers\SyliusSaferpayPlugin\Provider\OrderProviderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Webmozart\Assert\Assert;

final class AfterUnsuccessfulPaymentAction
{
    public function __construct(
        private OrderProviderInterface $orderProvider,
        private UrlGeneratorInterface $router,
    ) {
    }

    public function __invoke(Request $request, string $tokenValue): RedirectResponse
    {
        $order = $this->orderProvider->provide($tokenValue);

        $payments = $order->getPayments()->toArray();

        /** @var PaymentInterface|null $lastPayment */
        $lastPayment = array_pop($payments);
        Assert::notNull($lastPayment);

        /** @var PaymentInterface|null $penultimatePayment */
        $penultimatePayment = array_pop($payments);

        if (PaymentInterface::STATE_NEW === $lastPayment->getState()) {
            $this->addFlashMessageForPenultimatePayment($request, $penultimatePayment);

            return new RedirectResponse($this->router->generate(
                'sylius_shop_order_show',
                ['tokenValue' => $tokenValue],
            ));
        }

        if (PaymentInterface::STATE_COMPLETED === $lastPayment->getState()) {
            $this->addFlashMessage($request, 'info', 'sylius.payment.completed');
        }

        return new RedirectResponse($this->router->generate('sylius_shop_order_thank_you'));
    }

    private function addFlashMessage(Request $request, string $type, string $message): void
    {
        /** @var Session $session */
        $session = $request->getSession();
        $session->getFlashBag()->add($type, $message);
    }

    private function addFlashMessageForPenultimatePayment(Request $request, ?PaymentInterface $payment): void
    {
        if (null === $payment) {
            return;
        }

        if (PaymentInterface::STATE_CANCELLED === $payment->getState()) {
            $this->addFlashMessage($request, 'info', 'sylius.payment.cancelled');

            return;
        }

        $this->addFlashMessage($request, 'error', 'sylius.payment.failed');
    }
}
