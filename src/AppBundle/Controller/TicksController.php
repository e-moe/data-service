<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tick;
use AppBundle\Entity\TickKey;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/ticks")
 */
class TicksController extends Controller
{
    const DATA_FORMAT = 'json';
    const CONTENT_TYPE_HEADER = ['Content-Type' => 'application/json'];

    /**
     * @Route("/{key}/{id}", name="getOneTick", requirements={"id" = "\d+"})
     * @Method({"GET"})
     * @ParamConverter("key", options={"mapping": {"key": "name"}})
     *
     * @param TickKey $key
     * @param Tick $tick
     * @return Response
     */
    public function getOneAction(TickKey $key, Tick $tick): Response
    {
        if ($tick->getKey() != $key) {
            throw $this->createNotFoundException();
        }

        $userId = 1;

        if ($tick->getUserId() != $userId) {
            throw $this->createAccessDeniedException();
        }

        return new Response(
            $this->get('jms_serializer')->serialize($tick, self::DATA_FORMAT),
            Response::HTTP_OK,
            self::CONTENT_TYPE_HEADER
        );
    }

    /**
     * @Route("/{key}", name="getTickList")
     * @Method({"GET"})
     * @ParamConverter("key", options={"mapping": {"key": "name"}})
     *
     * @param TickKey $key
     * @return Response
     */
    public function getListAction(TickKey $key): Response
    {
        $userId = 1;
        $ticks = $this->getDoctrine()->getRepository('AppBundle:Tick')->findTicks($key, $userId);

        return new Response(
            $this->get('jms_serializer')->serialize($ticks, self::DATA_FORMAT),
            Response::HTTP_OK,
            self::CONTENT_TYPE_HEADER
        );
    }

    /**
     * @Route("/{key}/latest", name="getLatestTick")
     * @Method({"GET"})
     * @ParamConverter("key", options={"mapping": {"key": "name"}})
     *
     * @param TickKey $key
     * @return Response
     */
    public function getLatestAction(TickKey $key): Response
    {
        $userId = 1;
        return new Response(
            $this->get('jms_serializer')->serialize(
                $this->getDoctrine()->getRepository('AppBundle:Tick')->findLatest($key, $userId),
                self::DATA_FORMAT
            ),
            Response::HTTP_OK,
            self::CONTENT_TYPE_HEADER
        );
    }

    /**
     * @Route("/{key}", name="postNewTick")
     * @Method({"POST"})
     * @ParamConverter("key", class="AppBundle:TickKey", options={"repository_method" = "findByNameOrNew"})
     *
     * @param Request $request
     * @param TickKey $key
     * @return Response
     */
    public function postNewAction(Request $request, TickKey $key): Response
    {
        $userId = 1;
        $tick = new Tick();
        $tick->setKey($key)
            ->setUserId($userId)
            ->setVal($request->getContent());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($tick);
        $entityManager->flush();

        return new Response(null, Response::HTTP_CREATED, [
            'Location' => $this->generateUrl('getOneTick', [
                'key' => $key->getName(),
                'id' => $tick->getId()
            ]),
        ]);
    }
}
