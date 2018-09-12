<?php
namespace App\Controller\Api\v1;

use App\Api\ApiProblem;
use App\Api\ApiProblemException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\League;

class LeaguesController extends Controller
{
    /**
     * @param League|null $league
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTeamsAction(League $league = null)
    {
        if (!$league) {
            $apiProblem = new ApiProblem(400, ApiProblem::TYPE_NOT_FOUND);
            throw new ApiProblemException($apiProblem);
        }

        $teams = $league->getTeams();

        $response = array();
        foreach($teams as $team) {
            $response[] = array('id' => $team->getId(), 'name' => $team->getName());
        }
        return $this->json(array('status' => 200, 'data' => $response), 200);
    }

    /**
     * @param League|null $league
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction(League $league = null)
    {
        if (!$league) {
            $apiProblem = new ApiProblem(400, ApiProblem::TYPE_NOT_FOUND);
            throw new ApiProblemException($apiProblem);
        }

        try {
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($league);
            $em->flush();
        } catch (Exception $e) {
            return $this->json(array('status' => 400, 'message' => 'There was a problem deleting this league.'), 400);
        }

        return $this->json(array('status' => 200, 'message' => 'League deleted'), 200);
    }

}
