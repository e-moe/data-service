<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TickKey;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{
    const DATA_FORMAT = 'json';

    /**
     * @Route("/{key}", name="getTicks")
     * @Method({"GET"})
     * @ParamConverter("key", options={"mapping": {"key": "name"}})
     */
    public function getTicksAction(TickKey $key)
    {
        $ticks = $this->getDoctrine()->getRepository('AppBundle:Tick')->findBy(
            [
                'key' => $key,
                //'userId' => 0,
            ]
        );

        return new Response(
            $this->get('serializer')->serialize($ticks, self::DATA_FORMAT),
            Response::HTTP_OK,
            [
                'Content-Type', 'application/json',
            ]
        );
    }

    /**
     * @Route("/{key}/latest", name="getLatestTick")
     * @Method({"GET"})
     * @ParamConverter("key", options={"mapping": {"key": "name"}})
     */
    public function getLatestTickAction(TickKey $key)
    {
        return new JsonResponse('Not implemented');
    }
}
