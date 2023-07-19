<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request,UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();

        // Créer le formulaire et injecter l'objet $user
        $form = $this->createForm(RegisterType::class, $user);

        // Écouteur pour récupérer les données du formulaire et les traiter dans le contexte du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer toutes les données du formulaire
            $user = $form->getData();

            // Encoder le mot de passe de l'utilisateur
            $encodedPassword = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);

            // Enregistrer l'utilisateur dans la base de données
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Rediriger vers une autre page après l'enregistrement réussi (par exemple, une page de confirmation)
            return $this->redirectToRoute('registration_success');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
