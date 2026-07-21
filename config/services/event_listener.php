<?php

declare(strict_types=1);

use CommerceWeavers\SyliusSaferpayPlugin\Payment\EventListener\RefundPaymentOnTransitionListener;
use CommerceWeavers\SyliusSaferpayPlugin\Processor\RefundProcessorInterface;
use CommerceWeavers\SyliusSaferpayPlugin\TransactionLog\EventListener\PaymentAssertionFailureListener;
use CommerceWeavers\SyliusSaferpayPlugin\TransactionLog\EventListener\PaymentAssertionSuccessListener;
use CommerceWeavers\SyliusSaferpayPlugin\TransactionLog\EventListener\PaymentAuthorizationFailureListener;
use CommerceWeavers\SyliusSaferpayPlugin\TransactionLog\EventListener\PaymentAuthorizationSuccessListener;
use CommerceWeavers\SyliusSaferpayPlugin\TransactionLog\EventListener\PaymentCaptureFailureListener;
use CommerceWeavers\SyliusSaferpayPlugin\TransactionLog\EventListener\PaymentCaptureSuccessListener;
use CommerceWeavers\SyliusSaferpayPlugin\TransactionLog\EventListener\PaymentRefundSuccessListener;
use CommerceWeavers\SyliusSaferpayPlugin\TransactionLog\Resolver\DebugModeResolverInterface;
use Sylius\Calendar\Provider\DateTimeProviderInterface;
use Sylius\Component\Payment\PaymentTransitions;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set(RefundPaymentOnTransitionListener::class)
        ->args([
            service(RefundProcessorInterface::class),
        ])
        ->tag('kernel.event_listener', [
            'event' => 'workflow.sylius_payment.transition.'.PaymentTransitions::TRANSITION_REFUND,
            'priority' => -100,
        ])
    ;

    $services->set(PaymentAssertionFailureListener::class)
        ->args([
            service('commerce_weavers_saferpay.factory.transaction_log'),
            service('commerce_weavers_saferpay.manager.transaction_log'),
            service('sylius.repository.payment'),
            service(DateTimeProviderInterface::class),
        ])
        ->tag('messenger.message_handler', ['bus' => 'sylius.event_bus'])
    ;

    $services->set(PaymentAssertionSuccessListener::class)
        ->args([
            service('commerce_weavers_saferpay.factory.transaction_log'),
            service('commerce_weavers_saferpay.manager.transaction_log'),
            service('sylius.repository.payment'),
            service(DateTimeProviderInterface::class),
            service(DebugModeResolverInterface::class),
        ])
        ->tag('messenger.message_handler', ['bus' => 'sylius.event_bus'])
    ;

    $services->set(PaymentAuthorizationFailureListener::class)
        ->args([
            service('commerce_weavers_saferpay.factory.transaction_log'),
            service('commerce_weavers_saferpay.manager.transaction_log'),
            service('sylius.repository.payment'),
            service(DateTimeProviderInterface::class),
            service(DebugModeResolverInterface::class),
        ])
        ->tag('messenger.message_handler', ['bus' => 'sylius.event_bus'])
    ;

    $services->set(PaymentAuthorizationSuccessListener::class)
        ->args([
            service('commerce_weavers_saferpay.factory.transaction_log'),
            service('commerce_weavers_saferpay.manager.transaction_log'),
            service('sylius.repository.payment'),
            service(DateTimeProviderInterface::class),
            service(DebugModeResolverInterface::class),
        ])
        ->tag('messenger.message_handler', ['bus' => 'sylius.event_bus'])
    ;

    $services->set(PaymentCaptureFailureListener::class)
        ->args([
            service('commerce_weavers_saferpay.factory.transaction_log'),
            service('commerce_weavers_saferpay.manager.transaction_log'),
            service('sylius.repository.payment'),
            service(DateTimeProviderInterface::class),
            service(DebugModeResolverInterface::class),
        ])
        ->tag('messenger.message_handler', ['bus' => 'sylius.event_bus'])
    ;

    $services->set(PaymentCaptureSuccessListener::class)
        ->args([
            service('commerce_weavers_saferpay.factory.transaction_log'),
            service('commerce_weavers_saferpay.manager.transaction_log'),
            service('sylius.repository.payment'),
            service(DateTimeProviderInterface::class),
            service(DebugModeResolverInterface::class),
        ])
        ->tag('messenger.message_handler', ['bus' => 'sylius.event_bus'])
    ;

    $services->set(PaymentRefundSuccessListener::class)
        ->args([
            service('commerce_weavers_saferpay.factory.transaction_log'),
            service('commerce_weavers_saferpay.manager.transaction_log'),
            service('sylius.repository.payment'),
            service(DateTimeProviderInterface::class),
            service(DebugModeResolverInterface::class),
        ])
        ->tag('messenger.message_handler', ['bus' => 'sylius.event_bus'])
    ;
};
