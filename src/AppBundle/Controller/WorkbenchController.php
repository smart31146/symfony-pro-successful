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
use AppBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WorkbenchController extends Controller
{
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $admin = $this->isGranted('ROLE_ADMIN');
        if ($admin) {
            $entityManager = $this->getDoctrine()->getManager();
            $projects = $entityManager->getRepository(Project::class)->findAll();
            $projectsByAccess = [
                Access::DELETE => $projects,
                Access::WRITE => $projects,
                Access::READ => $projects
            ];
        } else {
            $projects = $user->getProjects();
            $projectsByAccess = $user->getProjectsByAccess();
        }

        return $this->render(
            'workbench/index.html.twig',
            [
                'projects' => $projects,
                'projectsByAccess' => $projectsByAccess,
                'admin' => $admin
            ]
        );
    }


    public function constructProjectAction(Request $request, Project $project)
    {
        $user = $this->getUser();
        $userProjects = $user->getProjectsByAccess();

        if (!$this->isGranted('ROLE_ADMIN') && !in_array($project, $userProjects[Access::WRITE], true)) {
            return $this->redirectToRoute('app.workbench.index');
        }

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app.workbench.index');
        }
        return $this->render(
            'workbench/project/edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    public function deleteProjectAction(Request $request, Project $project)
    {
        $user = $this->getUser();
        $userProjects = $user->getProjectsByAccess();

        if (!$this->isGranted('ROLE_ADMIN') && !in_array($project, $userProjects[Access::DELETE], true)) {
            return $this->redirectToRoute('app.workbench.index');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($project);
        $entityManager->flush();

        return $this->redirectToRoute('app.workbench.index');
    }
}