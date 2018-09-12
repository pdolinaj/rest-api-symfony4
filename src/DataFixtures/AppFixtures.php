<?php
namespace App\DataFixtures;

use App\Entity\League;
use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $footballLeagues = ['Premier League', 'Scottish Premiership', 'League to Delete'];

        $teamsEngland = [
            'AFC Bournemouth',
            'Arsenal',
            'Brighton & Hove Albion',
            'Burnley',
            'Cardiff City',
            'Chelsea',
            'Crystal Palace',
            'Everton',
            'Fulham',
            'Huddersfield Town',
            'Leicester City',
            'Liverpool',
            'Manchester City',
            'Manchester United',
            'Newcastle United',
            'Southampton',
            'Tottenham Hotspur',
            'Watford',
            'West Ham United',
            'Wolverhampton Wanderers'
        ];

        $teamsScottland = [
            'Aberdeen',
            'Celtic',
            'Dundee',
            'Hamilton Academical',
            'Heart of Midlothian',
            'Hibernian',
            'Kilmarnock',
            'Livingston',
            'Motherwell',
            'Rangers',
            'St Johnstone',
            'St Mirren'
        ];

        foreach($footballLeagues as $footballLeague) {
            $league = new League();
            $league->setName($footballLeague);
            $manager->persist($league);
            $manager->flush();

            if($league->getName() == 'Premier League') {
                foreach($teamsEngland as $teamEngland) {
                    $team = new Team();
                    $team->setName($teamEngland);
                    $team->setLeague($league);
                    $team->setStrip($teamEngland);
                    $manager->persist($team);
                }
            } elseif($league->getName() == 'Scottish Premiership') {
                foreach($teamsScottland as $teamScottland) {
                    $team = new Team();
                    $team->setName($teamScottland);
                    $team->setLeague($league);
                    $team->setStrip($teamScottland);
                    $manager->persist($team);
                }
            }
            $manager->flush();
        }

        //user - for generating the token
        $user = new User();
        $user->setUsername('king');
        $user->setPassword('$2y$13$5IvRj6u6l5E0kZqkcnSBFu8WKYTGmcPOxejppVAs6dq8pzwc7V9ZS'); //kong
        $manager->persist($user);
        $manager->flush();
    }
}