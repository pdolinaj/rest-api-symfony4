<?php
namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Api\ApiProblem;
use App\Api\ApiProblemException;
use App\Entity\Team;
use App\Form\TeamType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class TeamsController extends Controller
{

    public function getTeamAction(Team $team)
    {
        if (!$team) {
            $apiProblem = new ApiProblem(400, ApiProblem::TYPE_NOT_FOUND);
            throw new ApiProblemException($apiProblem);
        }
        return $this->json(array('status' => 200, 'data' => array(
            'team' => array('id' => $team->getId(), 'name' => $team->getName(), 'strip' => $team->getStrip()),
            'league' => array('id' => $team->getLeague()->getId(), 'name' => $team->getLeague()->getName()))
        ), 200);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function newAction(Request $request)
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);

        //$form->submit($request->request->get($form->getName()));
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            $this->throwApiProblemValidationException($form);
        }

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
        } catch (\Exception $e) {
            return $this->json(array('status' => 400, 'message' => 'There was a problem creating team.'), 400);
        }

        return $this->json(
            array('status' => 201, 'message' => 'Team created'), 201, array('Location' => sprintf('/api/v1/teams/%d', $team->getId()))
        );
    }

    /**
     * Update - accepts JSON parameters for request
     *
     * @param Request $request
     * @param Team|null $team
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction(Request $request, Team $team = null)
    {
        if (!$team) {
            $apiProblem = new ApiProblem(400, ApiProblem::TYPE_NOT_FOUND);
            throw new ApiProblemException($apiProblem);
        }

        $form = $this->createForm(TeamType::class, $team);
        $form->submit(json_decode($request->getContent(), true));

        if (!$form->isValid()) {
            $this->throwApiProblemValidationException($form);
        }

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
        } catch (\Exception $e) {
            return $this->json(array('status' => 400, 'message' => 'There was a problem updating team.'), 400);
        }

        return $this->json(
            array(
                'status' => 200,
                'message' => 'Team updated'
            )
        );
    }

    private function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }

    private function throwApiProblemValidationException(FormInterface $form)
    {
        $errors = $this->getErrorsFromForm($form);
        $apiProblem = new ApiProblem(
            400,
            ApiProblem::TYPE_VALIDATION_ERROR
        );
        $apiProblem->set('errors', $errors);
        throw new ApiProblemException($apiProblem);
    }

}

