<?php

namespace spec\Aa\AkeneoDataLoader\Report\LoadingResult;

use Aa\AkeneoDataLoader\Report\LoadingResult\Failure;
use PhpSpec\ObjectBehavior;

class FailureSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('product', 'Error', 123, 88, ['error1', 'error2']);
    }

    function it_returns_properties()
    {
        $this->getDataIdentifier()->shouldBe('product');
        $this->getMessage()->shouldBe('Error');
        $this->getErrorCode()->shouldBe(123);
        $this->getIndex()->shouldBe(88);
        $this->getErrors()->shouldBe(['error1', 'error2']);
    }

    function it_can_be_created_with_new_index()
    {
        $newFailure = $this->withIndex(86);

        $newFailure->shouldHaveType(Failure::class);
        $newFailure->getIndex()->shouldBe(86);
        
        $newFailure->getDataIdentifier()->shouldBe('product');
        $newFailure->getMessage()->shouldBe('Error');
        $newFailure->getErrorCode()->shouldBe(123);
        $newFailure->getErrors()->shouldBe(['error1', 'error2']);
    }
}
