<?php

namespace App\Configuration\ParamConverter;

use App\Dto\DtoInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestToDtoConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $param = $configuration->getName();

        $class = $configuration->getClass();

        /** @var DtoInterface $object */
        $object = new $class;

        foreach ($request->toArray() as $property => $value) {
            if (property_exists($object, $property)) {
                $object->{$property} = $value;
            }
        }

        $request->attributes->set($param, $object);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        if (null === $configuration->getClass()) {
            return false;
        }

        return is_subclass_of($configuration->getClass(), DtoInterface::class);
    }
}