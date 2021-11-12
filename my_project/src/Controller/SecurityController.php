<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Conge;
use App\Entity\Upload;
use App\Form\UploadType;
use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Form\CongeTypePhpType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Repository\CongeRepository;
use App\Repository\ActualiteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use ContainerF6n0khT\PaginatorInterface_82dac15;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
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
     * @Route("/actualite", name="actualite")
     */
    public function actualite(ActualiteRepository $actualiterepo, Request $request, PaginatorInterface $paginator)
    {
        $donnees = $actualiterepo->findAll();
        $actualite = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('User/actualite.html.twig', ['actualites' => $actualite]);
    }

    /**
     * @Route("/profile/{id}", name="profile_user")
     */
    public function profile_user($id, Request $request, ActualiteRepository $actualiterepo)
    {
        $upload = new Upload;
        $user = $this->getUser();
        /*$user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);*/
        $actualite = $actualiterepo->findAll();
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
     * @Route("/profile", name="your_profile")
     */
    public function profile()
    {
        return $this->render('User/homepage.html.twig');
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
     * @Route("/historique/{id}", name="historique_user")
     */
    public function historique($id, CongeRepository $congerepo)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $conges = $congerepo->findAll();
        return $this->render('Conge/historique.html.twig', ["user" => $user, "conges" => $conges]);
    }
}
