<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Form\Circuit1Type;
use App\Repository\CircuitRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/circuit')]
class CircuitController extends AbstractController
{
    #[Route('/', name: 'app_circuit_index', methods: ['GET'])]
    public function index(CircuitRepository $circuitRepository): Response
    {
        return $this->render('circuit/index.html.twig', [
            'circuits' => $circuitRepository->findAll(),
        ]);
    }

    #[Route('/client', name: 'client', methods: ['GET'])]
    public function client(CircuitRepository $circuitRepository): Response
    {
        return $this->render('circuit/clientCircuit.html.twig', [
            'circuits' => $circuitRepository->findAll(),
        ]);
    }
    #[Route('/front', name:'home')]
    public function front(): Response
    {
        return $this->render('/classe/front.html.twig');
    }


    #[Route('/new', name: 'app_circuit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $circuit = new Circuit();
        $form = $this->createForm(Circuit1Type::class, $circuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($circuit);
            $entityManager->flush();

            return $this->redirectToRoute('app_circuit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('circuit/new.html.twig', [
            'circuit' => $circuit,
            'form' => $form,
        ]);
    }

  
 

    #[Route('/admin/{id}', name: 'app_circuit_show', methods: ['GET'])]
    public function show(Circuit $circuit): Response
    {
        return $this->render('circuit/show.html.twig', [
            'circuit' => $circuit,
        ]);
    }

    // #[Route('/client/{id}', name: 'client_show', methods: ['GET'])]
    // public function clientshow(Circuit $circuit): Response
    // {
    //     // Replace 'YOUR_API_KEY' with the actual API key from OpenWeatherMap
    //     $apiKey = '171ed24ecb9a792457ced5f5dab6c147';
    
    //     // Replace with the OpenWeatherMap API endpoint for current weather
    //     $apiEndpoint = 'https://api.openweathermap.org/data/2.5/weather';
        
    //     try {
    //         $client = new Client();
            
    //         // Get the destination city from the Circuit entity
    //         $city = $circuit->getArrive();
    
    //         $response = $client->get($apiEndpoint, [
    //             'query' => [
    //                 'q' => $city,
    //                 'appid' => $apiKey,
    //             ],
    //         ]);
    
    //         $data = json_decode($response->getBody(), true);
    
    //         return $this->render('circuit/clientdetail.html.twig', [
    //             'circuit' => $circuit,
    //             'weatherData' => $data,
    //         ]);
    //     } catch (\Exception $e) {
    //         // Log the exception or handle it based on your application's requirements
    //         return $this->render('circuit/error.html.twig', [
    //             'error' => $e->getMessage(),
    //         ]);
    //     }
    // }


     #[Route('/client/{id}', name: 'client_show', methods: ['GET'])]
    public function clientshow(Circuit $circuit, HttpClientInterface $httpClient): Response
    {
        // Replace 'YOUR_API_KEY' with the actual API key from OpenWeatherMap
        $weatherApiKey = '171ed24ecb9a792457ced5f5dab6c147';
        $weatherApiEndpoint = 'https://api.openweathermap.org/data/2.5/weather';

        // Replace 'YOUR_UNSPLASH_ACCESS_KEY' with your Unsplash Access Key
        $unsplashAccessKey = '4NoNgVMOfpClC6-T-SF00aS4JvmJZ-PjR6duAJwO8mg';
        $unsplashEndpoint = 'https://api.unsplash.com/photos/random';

        try {
            // Weather API request
            $weatherResponse = $httpClient->request('GET', $weatherApiEndpoint, [
                'query' => [
                    'q' => $circuit->getArrive(),
                    'appid' => $weatherApiKey,
                ],
            ]);

            $weatherData = json_decode($weatherResponse->getContent(), true);

            // Unsplash API request for multiple photos (count parameter)
            $unsplashResponse = $httpClient->request('GET', $unsplashEndpoint, [
                'query' => [
                    'client_id' => $unsplashAccessKey,
                    'query' => $circuit->getArrive(),
                    'count' => 5, // Adjust the count to the desired number of photos
                ],
            ]);

            $unsplashPhotoData = $unsplashResponse->toArray();

            return $this->render('circuit/clientdetail.html.twig', [
                'circuit' => $circuit,
                'weatherData' => $weatherData,
                'unsplashPhotoData' => $unsplashPhotoData,
            ]);
        } catch (\Exception $e) {
            return $this->render('circuit/error.html.twig', [
                'error' => $e->getMessage(),
            ]);
        }
    }

   

    #[Route('/{id}/edit', name: 'app_circuit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Circuit $circuit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Circuit1Type::class, $circuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_circuit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('circuit/edit.html.twig', [
            'circuit' => $circuit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_circuit_delete', methods: ['POST'])]
    public function delete(Request $request, Circuit $circuit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$circuit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($circuit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_circuit_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/search', name: 'search_circuits', methods: ['GET'])]
public function search(Request $request, CircuitRepository $circuitRepository): Response
{
    $query = $request->query->get('query');
    $circuits = $circuitRepository->search($query);

    return $this->render('circuit/index.html.twig', [
        'circuits' => $circuits,
    ]);
}

#[Route('/searcher', name: 'searcher', methods: ['GET'])]
public function searching(Request $request, CircuitRepository $circuitRepository): Response
{
    $query = $request->query->get('query');
    $circuits = $circuitRepository->search($query);

    return $this->render('circuit/clientCircuit.html.twig', [
        'circuits' => $circuits,
    ]);
}
    
#[Route('/sorted-circuits', name: 'sorted_circuits')]
public function sortedCircuits(CircuitRepository $circuitRepository): Response
{
    $circuits = $circuitRepository->findAllSortedByPriceQueryBuilder();
   

    return $this->render('circuit/clientCircuit.html.twig', [
        'circuits' => $circuits,
    ]);
}
   
}
