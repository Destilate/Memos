<?php
namespace App\Controller;

use App\Form\CrewSelectType;
use App\Service\Task1Service;
use App\Service\Task2Service;
use App\Service\Task3Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TaskController extends AbstractController
{
    public function __construct(
        private Environment $twig,
    )
    {
    }

    public function index(): Response
    {
        $html = $this->twig->render('index.html.twig');
        return new Response($html);
    }

    public function task1(Request $request): Response
    {
        $itemCount = (int) $request->request->get('itemCount', 1000000);
        $min = (int) $request->request->get('min', 1);
        $max = (int) $request->request->get('max', 1000000);

        $duplicates = null;
        if ($request->isMethod('POST')) {
            $service = new Task1Service();
            $randomArray = $service->createRandomArray($itemCount, $min, $max);
            $duplicates = $service->checkForDuplicitiesInArray($randomArray);
        }

        $html = $this->twig->render('task1.html.twig', [
            'duplicates' => $duplicates,
            'itemCount' => $itemCount,
            'min' => $min,
            'max' => $max,
        ]);

        return new Response($html);
    }

    public function task2(): Response
    {
        $html = $this->twig->render('task2.html.twig');
        return new Response($html);
    }

    public function task2Result(Request $request): JsonResponse
    {
        try {
            $planetName =  $request->request->get('planet');
            $service = new Task2Service();

            return $service->findStarshipsWithPilotsFromPlanet($planetName);
        } catch (\Throwable $e) {
            error_log('Chyba v task2Result: ' . $e->getMessage());
            return new JsonResponse([
                'error' => true,
                'message' => 'Nastala chyba: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function task3(Request $request): Response
    {
        $form = $this->createForm(CrewSelectType::class);
        $form->handleRequest($request);

        $subordinates = null;
        $infectionPath = null;
        $selectedCrewMember = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $service = new Task3Service;
            $selectedCrewMember = $form->get('crew')->getData();
            $selectedType = $form->get('resultType')->getData();
            switch($selectedType) {
                case('subordinate'):
                    $subordinates = $service->getSubordinates($selectedCrewMember);
                    break;
                case('plague'):
                    $infectionPath = $service->tracePlaguePath($selectedCrewMember);
                    break;
            }
        }

        return $this->render('task3.html.twig', [
            'form' => $form->createView(),
            'subordinates' => $subordinates,
            'infectionPath' => $infectionPath,
            'selectedCrewMember' => $selectedCrewMember
        ]);
    }
}
