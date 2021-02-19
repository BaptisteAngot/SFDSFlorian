<?php

namespace App\Controller;

use App\Entity\Video;
use App\Repository\VideoRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class VideoController extends AbstractController
{
    /**
     * @Route("/api/movie/create", name="createMovie", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createMovie(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $video = new Video();
        $response = new Response();
        $error = [];
        $datas = json_decode($request->getContent(),true);
        $video->setType("movie");
        if ($datas !== null){
            if (isset($datas['name'])){
                $video->setName($datas['name']);
            }else {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                array_push($error, "No name");
            }
            if (isset($datas['synopsis'])){
                $video->setSynopsis($datas['synopsis']);
            }else {
                $response->setStatusCode(Response::HTTP_CREATED);
                array_push($error, "No synopsis");
            }
            if (isset($datas['date'])){
                $mediaDate = DateTime::createFromFormat("d/m/Y H:i:s", $datas["date"] . " 00:00:00");
                $video->setDate($mediaDate);
            }else {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                array_push($error, "No date");
            }

            if (empty($error))
            {
                $entityManager->persist($video);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent("Movie created at id : " . $video->getId());
            }else{
                $response->setContent(json_encode($error));
            }
        }else {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent("Bad syntax");
        }
        return $response;
    }

    /**
     * @Route("/movie/getAll", name="getAllMovie", methods={"GET"})
     * @param VideoRepository $videoRepository
     * @return Response
     */
    public function getAllMovie(VideoRepository $videoRepository): Response
    {
        $movies = $videoRepository->findBy(['Type' => "movie"]);
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent($this->serializeVideo($movies));
        return $response;
    }

    /**
     * @Route("front/movie/getAll", name="getAllMovieFront", methods={"GET"})
     * @param VideoRepository $videoRepository
     * @return Response
     */
    public function getAllMovieFront(VideoRepository $videoRepository): Response
    {
        $movies = $videoRepository->findBy(['Type' => "movie"]);
        return $this->render('home/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("front/movie/get/{id}", name="getOneMovieFront", methods={"GET"})
     * @param VideoRepository $videoRepository
     * @return Response
     */
    public function getOneMovieFront($id,VideoRepository $videoRepository): Response
    {
        $movies = $videoRepository->findBy(['Type' => "movie",'id'=> $id]);
        return $this->render('home/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/movie/get/{id}", name="getOneMovie", methods={"GET"})
     * @param $id
     * @param VideoRepository $videoRepository
     * @return Response
     */
    public function getOneMovie($id, VideoRepository $videoRepository): Response
    {
        $error = [];
        $response = new Response();
        $movies = $videoRepository->findBy(
            [
                'Type' => "movie",
                'id' => $id
            ]
        );
        if (empty($movies)){
            array_push($error, "Film inexistant");
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }else {
            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent($this->serializeVideo($movies));
        }
        return $response;
    }

    /**
     * @Route("/api/serie/create", name="createSerie", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createSerie(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $video = new Video();
        $response = new Response();
        $error = [];
        $datas = json_decode($request->getContent(),true);
        $video->setType("serie");
        if ($datas !== null){
            if (isset($datas['name'])){
                $video->setName($datas['name']);
            }else {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                array_push($error, "No name");
            }
            if (isset($datas['synopsis'])){
                $video->setSynopsis($datas['synopsis']);
            }else {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                array_push($error, "No synopsis");
            }
            if (isset($datas['date'])){
                $mediaDate = DateTime::createFromFormat("d/m/Y H:i:s", $datas["date"] . " 00:00:00");
                $video->setDate($mediaDate);
            }else {
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                array_push($error, "No date");
            }

            if (empty($error))
            {
                $entityManager->persist($video);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_CREATED);
                $response->setContent("Serie created at id : " . $video->getId());
            }else{
                $response->setContent(json_encode($error));
            }
        }else {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent("Bad syntax");
        }
        return $response;
    }

    /**
     * @Route("/serie/getAll", name="getAllSerie", methods={"GET"})
     * @param VideoRepository $videoRepository
     * @return Response
     */
    public function getAllSerie(VideoRepository $videoRepository): Response
    {
        $movies = $videoRepository->findBy(['Type' => "serie"]);
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent($this->serializeVideo($movies));
        return $response;
    }

    /**
     * @Route("/serie/get/{id}", name="getOneSerie", methods={"GET"})
     * @param $id
     * @param VideoRepository $videoRepository
     * @return Response
     */
    public function getOneSerie($id, VideoRepository $videoRepository): Response
    {
        $movies = $videoRepository->findBy(
            [
                'Type' => "serie",
                'id' => $id
            ]
        );
        $response = new Response();

        if (empty($movies)){
            array_push($error, "Film inexistant");
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }else {
            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent($this->serializeVideo($movies));
        }
        return $response;
    }

    /**
     * @Route("front/serie/getAll", name="getAllSerieFront", methods={"GET"})
     * @param VideoRepository $videoRepository
     * @return Response
     */
    public function getAllSerieFront(VideoRepository $videoRepository): Response
    {
        $movies = $videoRepository->findBy(['Type' => "serie"]);
        return $this->render('home/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("front/serie/get/{id}", name="getOneSerieFront", methods={"GET"})
     * @param VideoRepository $videoRepository
     * @return Response
     */
    public function getOneSerieFront($id,VideoRepository $videoRepository): Response
    {
        $movies = $videoRepository->findBy(['Type' => "serie",'id'=> $id]);
        return $this->render('home/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    private function serializeVideo($objet){
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);

        return $serializer->serialize($objet, 'json');
    }

}
