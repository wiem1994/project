<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Conge;
use App\Entity\Upload;
use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Form\CongeTypePhpType;
use App\Form\RegistrationType;
use App\Form\UploadType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/admin", name="security_register")
     */
    public function create(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        $conges = $this->getDoctrine()
            ->getRepository(Conge::class)
            ->findAll();
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach ($users as $user) {
                $temp = array(
                    'nom' => $user->getNom(),
                    'email' => $user->getEmail(),
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        }
        return $this->render('User/create.html.twig', [
            'User' => $form->createView(), 'users' => $users, 'conges' => $conges
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {
        return $this->render('User/login.html.twig');
    }

    /**
     * @Route("/")
     */
    public function acceuil()
    {
        return $this->redirectToRoute("your_profile");
    }

    /**
     * @Route("/profile", name="your_profile")
     */
    public function profile()
    {
        return $this->render('User/profile.html.twig');
    }
    /**
     * @Route("/profile/{id}", name="profile_user")
     */
    public function profile_user($id, Request $request)
    {
        $upload = new Upload;
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $actualite = $this->getDoctrine()
            ->getRepository(Actualite::class)
            ->findAll();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $upload->getName();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory', $fileName));
            $upload->setName($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('User/profile.html.twig', ['user' => $user, 'actualites' => $actualite, 'form' => $form->createView()]);
    }
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/conge/{id}/{conge}", name="conge_user")
     */
    public function demandeConge($id, Conge $conge = null, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        if (is_null($conge)) {
            dd('is null');
            $conge = new Conge();
        } else {
            // dd($conge);
        }

        $form = $this->createForm(CongeTypePhpType::class, $conge);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conge);
            $entityManager->flush();
        }
        return $this->render('Conge/conge.html.twig', ['conge' => $form->createView(), 'user' => $user]);
    }

    /**
     * @Route("/conge/{iduser}/{idconge}", name="validate_conge")
     */
    // public function validerConge($iduser, $idconge)
    // {
    //     $user = $this->getDoctrine()
    //         ->getRepository(User::class)
    //         ->find($id);
    //     $iduser = $user->getId();

    //     $conge = $this->getDoctrine()
    //         ->getRepository(Conge::class)
    //         ->find($id);
    //     $idconge = $conge->getId();

    //     return $this->render('Conge/conge.html.twig', ['conge' => $conge, "user" => $iduser]);
    // }

    /**
     * @Route("/historique/{id}", name="historique_user")
     */
    public function historique($id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $conges = $this->getDoctrine()
            ->getRepository(Conge::class)
            ->findAll();
        return $this->render('Conge/historique.html.twig', ["user" => $user, "conges" => $conges]);
    }
    /**
     * @Route("/valider/{id}", name="valider_conge")
     */
    public function validerConge($id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $conges = $this->getDoctrine()
            ->getRepository(Conge::class)
            ->findAll();
        return $this->render('Conge/valider.html.twig', ["user" => $user, "conges" => $conges]);
    }
}
