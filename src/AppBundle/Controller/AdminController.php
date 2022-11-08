<?php
/**
 * Created by PhpStorm.
 * User: harmakit
 * Date: 11/11/2018
 * Time: 23:06
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Access;
use AppBundle\Entity\Project;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Form\ProjectType;
use AppBundle\Form\RoleType;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function indexAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $projects = $entityManager->getRepository(Project::class)->findAll();
        $users = $entityManager->getRepository(User::class)->findAll();
        $roles = $entityManager->getRepository(Role::class)->findAll();

        $params = [
            'Projects' => $projects,
            'Users' => $users,
            'Roles' => $roles
        ];

        return $this->render(
            '/admin/index.html.twig', [
                'params' => $params
            ]
        );
    }

    public function listUserAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository(User::class)->findAll();

        return $this->render(
            'admin/user/list.html.twig',
            [
                'users' => $users
            ]
        );
    }

    public function constructUserAction(Request $request, User $user = null)
    {
        $create = false;
        if (!$user) {
            $create = true;
            $user = new User();
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            if ($password) {
                if (strlen($password) < 6) {
                    $form->get('password')->addError(new FormError('Password min length is 6'));
                }
                $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
            } else {
                if ($create) {
                    $form->get('password')->addError(new FormError('Password is not defined'));
                }
            }
            if ($create) {
                $user->setSecurityRoles([
                    'ROLE_USER'
                ]);
            }

            if (count($form->getErrors()) === 0) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app.admin.user.list');
            }
        }

        return $this->render(
            'admin/user/construct.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function deleteUserAction(Request $request, User $user )
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app.admin.user.list');
    }

    public function listRoleAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $roles = $entityManager->getRepository(Role::class)->findAll();

        return $this->render(
            'admin/role/list.html.twig',
            [
                'roles' => $roles
            ]
        );
    }

    public function constructRoleAction(Request $request, Role $role = null)
    {
        if (!$role) {
            $role = new Role();

            $RWD = new Access(Access::DELETE);
            $RW = new Access(Access::WRITE);
            $R = new Access(Access::READ);

            $role
                ->addAccess($RWD)
                ->addAccess($RW)
                ->addAccess($R)
            ;
        }

            $form = $this->createForm(RoleType::class, $role);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();

                $entityManager->persist($role);
                $entityManager->flush();

                return $this->redirectToRoute('app.admin.role.list');
            }
        return $this->render(
            'admin/role/construct.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function deleteRoleAction(Request $request, Role $role )
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($role);
        $entityManager->flush();

        return $this->redirectToRoute('app.admin.role.list');
    }

    public function listProjectAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $projects = $entityManager->getRepository(Project::class)->findAll();

        return $this->render(
            'admin/project/list.html.twig',
            [
                'projects' => $projects
            ]
        );
    }

    public function constructProjectAction(Request $request, Project $project = null)
    {
        $project = $project ?? new Project();

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app.admin.project.list');
        }
        return $this->render(
            'admin/project/construct.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function deleteProjectAction(Request $request, Project $project)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($project);
        $entityManager->flush();

        return $this->redirectToRoute('app.admin.project.list');
    }
}