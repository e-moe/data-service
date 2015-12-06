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

    /**
     * @Route("/{key}/{id}", name="getOneTick", requirements={"id" = "\d+"})
     * @Method({"GET"})
     * @ParamConverter("key", options={"mapping": {"key": "name"}})
     */
    public function getOneAction(TickKey $key, Tick $tick)
    {
        if ($tick->getKey() != $key) {
            return $this->createNotFoundException();
        }

        $userId = 1;

        if ($tick->getUserId() != $userId) {
            return $this->createAccessDeniedException();
        }

        return new Response(
            $this->get('jms_serializer')->serialize($tick, self::DATA_FORMAT),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    /**
     * @Route("/{key}", name="getTickList")
     * @Method({"GET"})
     * @ParamConverter("key", options={"mapping": {"key": "name"}})
     */
    public function getListAction(TickKey $key)
    {
        $userId = 1;
        $ticks = $this->getDoctrine()->getRepository('AppBundle:Tick')->findTicks($key, $userId);

        return new Response(
            $this->get('jms_serializer')->serialize($ticks, self::DATA_FORMAT),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    /**
     * @Route("/{key}/latest", name="getLatestTick")
     * @Method({"GET"})
     * @ParamConverter("key", options={"mapping": {"key": "name"}})
     */
    public function getLatestAction(TickKey $key)
    {
        $userId = 1;
        return new Response(
            $this->get('jms_serializer')->serialize(
                $this->getDoctrine()->getRepository('AppBundle:Tick')->findLatest($key, $userId),
                self::DATA_FORMAT
            ),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    /**
     * @Route("/{key}", name="postNewTick")
     * @Method({"POST"})
     * @ParamConverter("key", class="AppBundle:TickKey", options={"repository_method" = "findByNameOrNew"})
     */
    public function postNewAction(Request $request, TickKey $key)
    {
        $userId = 1;
        $tick = new Tick();
        $tick->setKey($key)
            ->setUserId($userId)
            ->setVal($request->getContent());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($tick);
        $entityManager->flush();

        return $this->forward('AppBundle:Ticks:getOne', ['key' => $key->getName(), 'id' => $tick->getId()]);
    }
}
