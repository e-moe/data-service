<?php

namespace AppBundle\Controller;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController
{
    /**
     * @var bool Show error (false) or exception (true) pages by default.
     */
    protected $debug;

    /**
     * @param bool $debug
     */
    public function __construct($debug)
    {
        $this->debug = $debug;
    }

    /**
     * Converts an Exception to a Response.
     *
     * A "showException" request parameter can be used to force display of an error page (when set to false) or
     * the exception page (when true). If it is not present, the "debug" value passed into the constructor will
     * be used.
     *
     * @param Request              $request   The request
     * @param FlattenException     $exception A FlattenException instance
     * @param DebugLoggerInterface $logger    A DebugLoggerInterface instance
     *
     * @return Response
     *
     * @throws \InvalidArgumentException When the exception template does not exist
     */
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {
        $showException = $request->attributes->get('showException', $this->debug); // As opposed to an additional parameter, this maintains BC
        $code = $exception->getStatusCode();

        $response = [
            'error' => $code,
            'message' => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
        ];

        if ($showException) {
            $response['exception'] = $exception->toArray();
        }
        return new JsonResponse($response, $code);
    }
}
