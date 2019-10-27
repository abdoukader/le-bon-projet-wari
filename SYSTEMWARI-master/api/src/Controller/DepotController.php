<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class DepotController extends AbstractController
{
    /**
     * @Route("/depot", name="transaction")
     */
    public function compte(Request $request, SerializerInterface $serializer,
        EntityManagerInterface $entityManager, ValidatorInterface $validator) {
            $values = json_decode($request->getContent());
            if (isset($values->somme)) {
                $depot = new Depot();

                $depot->setUser($this->getUser());
                $depot->setSomme($values->somme);
                $depot->setDate(new \DateTime('now'));
                $dep = $this->getDoctrine()->getRepository(Compte::class)->findOneBy(array("numcompte" => ($values->numcompte)));
           
                $dep->setSolde($dep->getSolde() + $values->somme);
                $depot->setCompte($dep);
                $errors = $validator->validate($depot);
                if (count($errors)) {
                    $errors = $serializer->serialize($errors, 'json');
                    return new Response($errors, 500, ['Content-Type' => 'Application/json']);
                }
                $entityManager->persist($depot);
                $entityManager->flush();
                $data = ['status' => 201, 'message' => 'compte alimenter'];
                return new JsonResponse($data, 201);
            }
            $data = ['status' => 500, 'message' => 'erreurs'];
            return new JsonResponse($data, 500);
        }
}
