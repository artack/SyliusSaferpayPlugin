<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator) {
    $containerConfigurator->extension('sylius_twig_hooks', [
        'hooks' => [
            'sylius_shop.shared.form.select_payment.payment.choice.details' => [
                'saferpay_payment_method_logos' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Shop/Checkout/SelectPayment/_paymentMethodLogos.html.twig',
                    'priority' => -100,
                ],
            ],

            'sylius_admin.payment_method.update.content.form.sections.gateway_configuration' => [
                'saferpay_config' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Admin/PaymentMethod/Form/GatewayConfiguration/_config.html.twig',
                    'priority' => 50,
                ],
            ],
            'sylius_admin.payment_method.create.content.form.sections.gateway_configuration' => [
                'saferpay_config' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Admin/PaymentMethod/Form/GatewayConfiguration/_config.html.twig',
                    'priority' => 50,
                ],
            ],

            'sylius_admin.base#javascripts' => [
                'cw_scripts' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Admin/_scripts.html.twig',
                    'priority' => 5,
                ],
            ],
            'sylius_admin.base#stylesheets' => [
                'cw_styles' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Admin/_styles.html.twig',
                    'priority' => 5,
                ],
            ],

            'commerce_weavers_saferpay.admin.transaction_log.show' => [
                'sidebar' => [
                    'template' => '@SyliusAdmin/shared/crud/common/sidebar.html.twig',
                    'priority' => 200,
                ],
                'navbar' => [
                    'template' => '@SyliusAdmin/shared/crud/common/navbar.html.twig',
                    'priority' => 100,
                ],
                'content' => [
                    'template' => '@SyliusAdmin/shared/crud/common/content.html.twig',
                    'priority' => 0,
                ],
            ],
            'commerce_weavers_saferpay.admin.transaction_log.show.content' => [
                'flashes' => [
                    'template' => '@SyliusAdmin/shared/crud/common/content/flashes.html.twig',
                    'priority' => 300,
                ],
                'header' => [
                    'template' => '@SyliusAdmin/shared/crud/common/content/header.html.twig',
                    'priority' => 200,
                ],
                'body' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Admin/TransactionLogs/Show/_body.html.twig',
                    'priority' => 0,
                ],
            ],
            'commerce_weavers_saferpay.admin.transaction_log.show.content.header' => [
                'breadcrumbs' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Admin/TransactionLogs/Show/Header/_breadcrumbs.html.twig',
                    'priority' => 100,
                ],
                'title_block' => [
                    'template' => '@SyliusAdmin/shared/crud/common/content/header/title_block.html.twig',
                    'priority' => 0,
                ],
            ],
            'commerce_weavers_saferpay.admin.transaction_log.show.content.header.title_block' => [
                'title' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Admin/TransactionLogs/Show/Header/_title.html.twig',
                    'priority' => 0,
                ],
            ],

            'commerce_weavers_saferpay.admin.payment_method.configure_payment_methods' => [
                'sidebar' => [
                    'template' => '@SyliusAdmin/shared/crud/common/sidebar.html.twig',
                    'priority' => 200,
                ],
                'navbar' => [
                    'template' => '@SyliusAdmin/shared/crud/common/navbar.html.twig',
                    'priority' => 100,
                ],
                'content' => [
                    'template' => '@SyliusAdmin/shared/crud/common/content.html.twig',
                    'priority' => 0,
                ],
            ],
            'commerce_weavers_saferpay.admin.payment_method.configure_payment_methods.content' => [
                'flashes' => [
                    'template' => '@SyliusAdmin/shared/crud/common/content/flashes.html.twig',
                    'priority' => 300,
                ],
                'header' => [
                    'template' => '@SyliusAdmin/shared/crud/common/content/header.html.twig',
                    'priority' => 200,
                ],
                'form' => [
                    'template' => '@SyliusAdmin/shared/crud/common/content/form.html.twig',
                    'priority' => 0,
                ],
            ],
            'commerce_weavers_saferpay.admin.payment_method.configure_payment_methods.content.header' => [
                'breadcrumbs' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Admin/PaymentMethod/ConfigurePaymentMethods/Header/_breadcrumbs.html.twig',
                    'priority' => 100,
                ],
                'title_block' => [
                    'template' => '@SyliusAdmin/shared/crud/common/content/header/title_block.html.twig',
                    'priority' => 0,
                ],
            ],
            'commerce_weavers_saferpay.admin.payment_method.configure_payment_methods.content.header.title_block' => [
                'title' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Admin/PaymentMethod/ConfigurePaymentMethods/Header/_title.html.twig',
                    'priority' => 0,
                ],
            ],
            'commerce_weavers_saferpay.admin.payment_method.configure_payment_methods.content.form' => [
                'allowed_payment_methods' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Admin/PaymentMethod/ConfigurePaymentMethods/Form/_allowedPaymentMethods.html.twig',
                    'priority' => 20,
                ],
                'buttons' => [
                    'template' => '@CommerceWeaversSyliusSaferpayPlugin/Admin/PaymentMethod/ConfigurePaymentMethods/Form/_buttons.html.twig',
                    'priority' => 10,
                ],
            ],
        ],
    ]);
};
