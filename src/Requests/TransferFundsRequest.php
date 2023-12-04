<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class TransferFundsRequest extends BaseRequest
{
    #[NotBlank()]
    #[Type('integer')]
    protected int $account_to;

    #[NotBlank()]
    #[Type('numeric')]
    protected float $amount;

    #[NotBlank()]
    #[type('string')]
    #[Length(min: 3, max: 3)]
    protected string $currency;
}