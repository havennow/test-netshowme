<?php

declare(strict_types=1);

namespace App\Email\Http\Controller;

use App\Email\Service\EmailService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Exception;

/**
 * Class SearchUniqueAction
 * @package App\Job\Http\Controller
 */
class SearchUniqueAction
{
    /**
     * @var \App\Email\Service\EmailService
     */
    private $emailService;

    /**
     * SearchUnique constructor.
     * @param EmailService $emailService
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(int $id, Request $request)
    {
        try {
            $data = $this->emailService->find($id);
        } catch (Exception $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], $exception->getCode() ? $exception->getCode() : Response::HTTP_BAD_REQUEST);
        } catch (Throwable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], $exception->getCode() ? $exception->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'data' => $data,
            'status' => 'ok'
        ], Response::HTTP_OK);
    }
}
