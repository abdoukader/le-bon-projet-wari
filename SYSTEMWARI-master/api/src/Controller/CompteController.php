<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Partenaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/apii")
 */
class CompteController extends AbstractController
{
    /**
     * @Route("/compte", name="compte",methods={"POST"})
     */
    public function creercompte(Request $request, SerializerInterface $serializer,
        EntityManagerInterface $entityManager, ValidatorInterface $validator, PartenaireRepository $partenaire) {
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);
        $values = $request->request->all();
        $form->submit($values);

        $dep=$partenaire->findOneBy(["ninea" =>$values["ninea"]]);
        
        $compte->setPartenaire($dep);
        $recup = substr($dep->getNinea(), 0, 2);
        while (true) {
            if (time() % 1 == 0) {
                $alea = rand(100000000, 999999999);
                break;
            }
            slep(1);
        }
        $concat = $recup . $alea;
        $compte->setSolde(0);
        $compte->setNumcompte($concat);

        $errors = $validator->validate($compte);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json',
            ]);
        }

        $entityManager->persist($compte);
        $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => 'Le compte vient d\'etre créer.',
        ];
        return new JsonResponse($data, 201);

    }
}
