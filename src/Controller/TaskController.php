<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\CrewSelectType;
use App\Form\Task1Type;
use App\Form\Task2Type;
use App\Service\Task1Service;
use App\Service\Task2Service;
use App\Service\Task3Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        $defaultData = [
            'itemCount' => 1000000,
            'min' => 1,
            'max' => 1000000,
        ];

        $form = $this->createForm(Task1Type::class);

        if (!$request->isMethod('POST')) {
            $form->setData($defaultData);
        }

        $form->handleRequest($request);

        $duplicates = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $service = new Task1Service();
            $randomArray = $service->createRandomArray($data['itemCount'], $data['min'], $data['max']);
            $duplicates = $service->checkForDuplicitiesInArray($randomArray);
        }

        return $this->render('task1.html.twig', [
            'form' => $form->createView(),
            'duplicates' => $duplicates,
        ]);
    }

    public function task2(Request $request): Response
    {
        $form = $this->createForm(Task2Type::class);
        $form->handleRequest($request);

        $resultJson = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $planetName = $data['planet'];

            try {
                $service = new Task2Service();
                $resultJson = $service->findStarshipsWithPilotsFromPlanetPrettyJson($planetName);
            } catch (\Throwable $e) {
                $message = preg_replace('/\s+/', ' ', $e->getMessage());
                $resultJson = json_encode([
                    'error' => true,
                    'exception' => get_class($e),
                    'message' => 'Nastala chyba: ' . $message,
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
        }

        return $this->render('task2.html.twig', [
            'form' => $form->createView(),
            'resultJson' => $resultJson,
        ]);
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
