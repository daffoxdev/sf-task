<?php

namespace App\Configuration\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestToDtoConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration)
    {
        // TODO: Implement apply() method.
    }

    public function supports(ParamConverter $configuration)
    {
        // TODO: Implement supports() method.
    }
}