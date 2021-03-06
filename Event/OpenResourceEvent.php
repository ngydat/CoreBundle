<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Claroline\CoreBundle\Event\DataConveyorEventInterface;
use Claroline\CoreBundle\Event\MandatoryEventInterface;
use Claroline\CoreBundle\Entity\Resource\AbstractResource;

/**
 * Event dispatched by the resource controller when a resource is open
 */
class OpenResourceEvent extends Event implements MandatoryEventInterface, DataConveyorEventInterface
{
    private $resource;
    private $response;
    private $isPopulated = false;

    public function __construct(AbstractResource $resource)
    {
        $this->resource = $resource;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getResourceNode()
    {
        return $this->resource->getResourceNode();
    }

    public function setResponse($response)
    {
        $this->response = $response;
        $this->isPopulated = true;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function isPopulated()
    {
        return $this->isPopulated;
    }
}
