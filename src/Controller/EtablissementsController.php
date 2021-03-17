<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class HelloController extends AbstractController
{
  /**
   * @Route("/etablissements")
   */
  public function randomNameAction(): Response
  {
    return new Response(
      "<html><body><h1>Sa marche</h1></body></html>"
    );
  }
}
