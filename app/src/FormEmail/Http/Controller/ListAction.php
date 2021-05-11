<?php

declare(strict_types=1);

namespace App\FormEmail\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ListAction
 * @package App\FormEmail\Http\Controller
 */
class ListAction extends AbstractController
{

    public function __invoke(Request $request)
    {
        return $this->render('FormEmail/Resources/views/index.html.twig', ['message' => 'hello php']);
    }
}
