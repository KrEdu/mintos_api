<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints\Type;

class GetTransactionsRequest extends BaseRequest
{
    #[Type('integer')]
    protected int $offset;

    #[Type('integer')]
    protected int $limit;
}
