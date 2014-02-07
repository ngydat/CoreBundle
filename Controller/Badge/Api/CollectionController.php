<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Controller\Badge\Api;

use Claroline\CoreBundle\Entity\Badge\BadgeCollection;
use Claroline\CoreBundle\Form\Badge\BadgeCollectionType;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/internalapi/badge_collection")
 */
class CollectionController extends Controller
{
    /**
     * @Route("/", name="claro_badge_collection_add", defaults={"_format" = "json"})
     * @Method({"POST"})
     * @ParamConverter("user", options={"authenticatedUser" = true})
     */
    public function newAction(Request $request, $user)
    {
        $collection = new BadgeCollection();
        $collection->setUser($user);

        return $this->processForm($request, $collection);
    }

    private function processForm(Request $request, BadgeCollection $collection)
    {
        $statusCode = (null === $collection->getId()) ? 201 : 204;

        $form = $this->createForm(new BadgeCollectionType(), $collection);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($collection);
            $entityManager->flush();

            $view = View::create(array('status' => 'ok'), $statusCode);
            return $this->get("fos_rest.view_handler")->handle($view);
        }

        $view = View::create($form, 400);
        return $this->get("fos_rest.view_handler")->handle($view);
    }
}
