<?php

namespace App\Controller;

use App\Entity\Tarifs;
use App\Entity\Transaction;
use App\Entity\User;
use App\Form\Transaction1Type;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api")
 */
class SecurityController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * @Route("/register", name="register", methods={"POST"})
     *
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $values = $request->request->all();
        $file = $request->files->all()[
            "imageName"
        ];
        $form->submit($values);
        $user->setPassword($passwordEncoder->encodePassword($user, $values['password']));
        $profil = $user->getProfil();
        $role = [];
        if ($profil == "admin") {
            $role = ["ROLE_ADMIN"];
        } elseif ($profil == "user") {
            $role = ["ROLE_USER"];
        }
        $user->setRoles($role);
        $errors = $validator->validate($user);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json',
            ]);
        }
        $user->setImageFile($file);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        $data = [
            'status' => 201,
            'message' => 'L\'utilisateur a été bien créé',
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/login", name="token", methods={"POST"})
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */

    public function login(Request $request, JWTEncoderInterface $jwtEncoder)
    {

        $values = json_decode($request->getContent());
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'username' => $values->username,
        ]);

        if (!$user) {
            return new JsonResponse(['l\utilisateur n\existe pas']);
        }

        $isValid = $this->passwordEncoder->isPasswordValid($user, $values->password);

        if (!$isValid) {
            return new JsonResponse(['veuillez saisir un mot de pass']);
        }
        if ($user->getStatut() == 'bloquer') {

            return new JsonResponse(['Veuillez contacter votre administrateur vous etes bloqué']);
        }

        $token = $jwtEncoder->encode([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'exp' => time() + 3600, // 1 hour expiration
        ]);

        return new JsonResponse(['token' => $token]);
    }

    /**
     * @Route("/bloquer/{id}" , name="bloquer", methods={"GET"})
     */
    public function bloquerdebloquer(Request $request, User $users, UserRepository $userRepo, EntityManagerInterface $entityManager): Response
    {
        $values = json_decode($request->getContent());
        $user = $userRepo->find($users->getId());
        if ($user->getStatut() == "debloquer") {
            $user->SetStatut("bloquer");
            $entityManager->flush();
            $data = [
                'statu' => 201,
                'messag' => 'utilisateur bloquer',
            ];
            return new JsonResponse($data);
        }
        $user->SetStatus("debloquer");
        $entityManager->flush();
        $data = [
            'status' => 201,
            'message' => 'utilisateur debloquer',
        ];
        return new JsonResponse($data);

    }
    /**
     * @Route("/listerU" , name="listerUser" ,methods={"GET"})
     */
    public function listerUser(UserRepository $userRepository, SerializerInterface $serializer)
    {

        $user = $userRepository->findAll();
        $users = $serializer->serialize($user, 'json', [
            'group' => ['show'],
        ]);
        return new Response($users, 201);

    }

    /**
     * @Route("/tarifs", methods={"POST","GET"})
     *
     */
    public function tarif(Request $request)
    {
        $trans = new Transaction();
        $form = $this->createForm(Transaction1Type::class,$trans);
        $data = $request->request->all();
        $form->submit($data);
        
        $argent = $form->get('montant')->getData();
        $frais = $this->getDoctrine()->getRepository(Tarifs::class)->findAll();
        $commission=0;
        foreach ($frais as $values) {
            $values->getMin();
            $values->getMax();
            $values->getValeur();
           
            if ($argent >= $values->getmin() && $argent <= $values->getMax()) {
                $commission = $values->getValeur();
            }
        }
        //var_dump($commission);die();
        return new JsonResponse($commission);

    }
    
    
   
   




}
