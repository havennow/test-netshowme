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
 * Class CreateAction
 * @package App\Email\Http\Controller
 */
class CreateAction
{
    /**
     * @var \App\Email\Service\EmailService
     */
    private $emailService;

    /**
     * CreateAction constructor.
     * @param EmailService $emailService
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $data = [];
            $data['ip'] = $request->getClientIp();
            $data['name'] = $request->get('name');
            $data['email'] = $request->get('email');
            $data['phone'] = $request->get('phone');
            $data['message'] = $request->get('message');

            if (!empty($request->getContent())) {
                $data = array_merge(json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR), $data);
            }

            $this->emailService->create($data, $request->files);
        } catch (Exception $exception) {
            return new JsonResponse(['error' => $exception->getMessage()],
                $exception->getCode() ?: Response::HTTP_BAD_REQUEST);
        } catch (Throwable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()],
                $exception->getCode() ?: Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'ok'], Response::HTTP_CREATED);
    }
}
