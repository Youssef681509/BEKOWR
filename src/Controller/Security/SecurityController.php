<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Form\UserChangePasswordType;
use App\Form\UserWithoutPasswordType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SecurityController extends AbstractController
{

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $userRepository,
        private ManagerRegistry $doctrine,
        private PaginatorInterface $paginator
    )
    {}

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/users', name: 'app_user_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // $userFilter = new UserFilter();
        // $form = $this->createForm(UserFilterType::class, $userFilter);
        // $form->handleRequest($request);

        // if($form->isSubmitted() && $form->isSubmitted()){

        //     dd($userFilter);

        //     return $this->render('security/_itemData.html.twig', []);
        // }

        return $this->render('security/index.html.twig');
    }

    #[Route('/get_all', name:'app_user_all', methods: ["GET"])]
    public function getData(Request $request): Response {

        $query = $this->paginator->paginate(
            $this->userRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('security/_itemData.html.twig', [
            'users' => $query,
        ]);
    }

    #[Route('/register', name: 'app_user_register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );

            $user->setPassword($hashedPassword);

            $manager = $this->doctrine->getManager();

            // foreach ($user->getUserRoles() as $role) {
            //     $user->addUserRole($role);
            //     $role->addUser($user);
            //     $manager->persist($role);
            // }

            $manager->flush();

            $this->userRepository->save($user, true);

            $this->addFlash('success', 'Opération réussi');

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('security/registerAdmin.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/subscriber', name: 'app_user_subscriber', methods: ['GET', 'POST'])]
    public function subscriber(Request $request): Response {

        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );

            $user->setPassword($hashedPassword);

            $manager = $this->doctrine->getManager();

            // foreach ($user->getUserRoles() as $role) {
            //     $user->addUserRole($role);
            //     $role->addUser($user);
            //     $manager->persist($role);
            // }

            $manager->flush();

            $this->userRepository->save($user, true);

            $this->addFlash('success', 'Opération réussi');

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('security/subscriber.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/register_without_password', name: 'app_user_register_wPass', methods: ['GET', 'POST'])]
    public function registerWithoutPassword(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserWithoutPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainTextPassword = "password";

            $hashedPassword = $this->passwordHasher->hashPassword($user, $plainTextPassword);

            $user->setPassword($hashedPassword);

            $manager = $this->doctrine->getManager();

            $manager->flush();

            $this->userRepository->save($user, true);

            $this->addFlash('success', 'Opération réussi');

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('security/registerAdmin.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);

        return $this->render('security/show.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[IsGranted(
        attribute: new Expression('user.id === request.query.getInt(\'\')')
    )]
    #[Route('/{id}/edit/', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        // $originalRoles = new ArrayCollection();
        // $roles = $this->roleRepository->getRoleByUserId($user->getId());

        // foreach ($roles as $role) {
        //     $originalRoles->add($role);
        // }

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->doctrine->getManager();

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );

            $user->setPassword($hashedPassword);

            // $manager->persist($user);


            // foreach ($originalRoles as $role) {
            //     if (false === $user->getUserRoles()->contains($role)) {
            //         $role->removeUser($user);
            //         $user->removeUserRole($role);
            //     } else {
            //         foreach ($user->getUserRoles() as $role2) {
            //             $user->addUserRole($role2);
            //             $role2->addUser($user);
            //             $manager->persist($role2);
            //         }
            //     }
            // }

            // foreach ($user->getUserRoles() as $role) {
            //     $role->addUser($user);
            //     $manager->persist($role);
            // }

            $this->addFlash('success','Opération réussi');

            $manager->flush();

            $this->userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('security/edit.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

    #[Route("/{id}/change_password", "app_user_ch_password", methods: ['GET', 'POST'])]
    public function changePassword(Request $request, User $user): Response
    {

        $form = $this->createForm(UserChangePasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $holdPassword = $request->request->all()['user_change_password']['oldPassword'];
            $newPassword = $request->request->all()['user_change_password']['newPassword']['first'];

            if ($this->passwordHasher->isPasswordValid($user, $holdPassword) === true) {

                $hashedPassword = $this->passwordHasher->hashPassword($user, $newPassword);

                $this->userRepository->upgradePassword($user, $hashedPassword);

                return $this->redirectToRoute('app_logout', [], Response::HTTP_SEE_OTHER);
            }
            else
            {
                $this->addFlash('warning', 'Attention votre ancien mot de passe ne correspond pas.');

                return $this->render('security/changePassword.html.twig', [
                    'user' => $user,
                    'form' => $form,
                ]);
            }
        }

        return $this->render('security/changePassword.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route("/{id}/admin_change_password", "app_admin_ch_password", methods: ['GET', 'POST'])]
    public function adminChangePassword(Request $request, User $user): Response
    {

        $form = $this->createForm(UserChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $holdPassword = $request->request->all()['user_change_password']['oldPassword'];
            $newPassword = $request->request->all()['user_change_password']['newPassword']['first'];

            if ($this->passwordHasher->isPasswordValid($user, $holdPassword) === true) {

                $hashedPassword = $this->passwordHasher->hashPassword($user, $newPassword);

                $user->setPassword($hashedPassword);

                $this->userRepository->save($user, true);

                return $this->render('security/_changePassword.html.twig', [
                    'user' => $user,
                    'form' => $form,
                ]);
            }
            else
            {
//                $this->addFlash('warning', 'Attention votre ancien mot de passe ne correspond pas.');

//                return $this->redirectToRoute('app_user_index', [], 422);
                return $this->json([
                    'message' => 'Mot de passe invalide.'
                ], '422');
            }
        }

        return $this->render('security/_changePassword.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {

            $this->userRepository->remove($user, true);

            $this->addFlash('success', 'Opération réussi !!');
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
