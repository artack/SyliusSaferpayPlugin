<?php

declare(strict_types=1);

namespace spec\CommerceWeavers\SyliusSaferpayPlugin\Payum\ValueObject;

use PhpSpec\ObjectBehavior;

final class SaferpayApiSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('username', 'password', 'customer_id', 'terminal_id', true);
    }

    public function it_returns_a_username(): void
    {
        $this->getUsername()->shouldReturn('username');
    }

    public function it_returns_a_password(): void
    {
        $this->getPassword()->shouldReturn('password');
    }

    public function it_returns_a_customer_id(): void
    {
        $this->getCustomerId()->shouldReturn('customer_id');
    }

    public function it_returns_a_terminal_id(): void
    {
        $this->getTerminalId()->shouldReturn('terminal_id');
    }

    public function it_returns_if_it_is_a_sandbox(): void
    {
        $this->isSandbox()->shouldReturn(true);
    }
}
