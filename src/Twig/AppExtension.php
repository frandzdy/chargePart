<?php
    
    namespace App\Twig;
    
    use App\Entity\Abonnement;
    use App\Entity\InterestExit;
    use App\Entity\InterestHobbies;
    use App\Entity\InterestSports;
    use App\Entity\User;
    use App\Service\MatchManager;
    use App\Service\UserManager;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\EntityManagerInterface;
    use JetBrains\PhpStorm\Pure;
    use Twig\Extension\AbstractExtension;
    use Twig\TwigFunction;
    
    /**
     * Extension Twig de l'application
     */
    class AppExtension extends AbstractExtension
    {
        /**
         */
        public function __construct(
            private UserManager $userManager,
            private MatchManager $matchManager
        ) {}
        
        /**
         * @inheritDoc
         */
        public function getFunctions(): array
        {
            return [
                new TwigFunction('getAbonnements', [$this, 'getAbonnements']),
                new TwigFunction('getCommunInterest', [$this, 'getCommunInterest']),
                new TwigFunction('getDistance', [$this, 'getDistance']),
                new TwigFunction('isAMatch', [$this, 'isAMatch']),
                new TwigFunction('hasAMatch', [$this, 'hasAMatch']),
                new TwigFunction('numberCommunMatch', [$this, 'numberCommunMatch']),
            ];
        }
        
        /**
         * Retourne les abonnements dans twig
         */
        public function getAbonnements(string $type): ?array
        {
            return Abonnement::getAvailableAbonnements($type);
        }
        /**
         * Retourne les abonnements dans twig
         */
        public function getDistance(User $userConnected, User $userMatch): ?float
        {
            return $this->userManager->distance(
                $userConnected->getLat(),
                $userConnected->getLon(),
                $userMatch->getLat(),
                $userMatch->getLon()
            );
        }
        /**
         * Retourne les points commun entre deux personnes
         */
        public function getCommunInterest(User $userConnected, User $userMatch, string $type)
        {
            $function = 'get' . $type;
            
            return $this->$function($userConnected, $userMatch);
        }
        
        #[Pure] private function getHobbies(User $userConnected, User $userMatch, bool $numberOfCommun = false): string|int
        {
            $response = '';
            $count = 0;
            foreach ($userMatch->getInterestHobbies() as $interestHobbie) {
                if (InterestHobbies::ART === $interestHobbie && in_array(
                        InterestHobbies::ART,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">L\'art</li>';
                    $count++;
                } elseif (InterestHobbies::CARS === $interestHobbie
                    && in_array(
                        InterestHobbies::CARS,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les voitures</li>';
                    $count++;
                } elseif (InterestHobbies::CHAT === $interestHobbie
                    && in_array(
                        InterestHobbies::CHAT,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Discuter / Parler</li>';
                    $count++;
                } elseif (InterestHobbies::DO_IT_YOURSELF === $interestHobbie
                    && in_array(
                        InterestHobbies::DO_IT_YOURSELF,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Le bricolage</li>';
                    $count++;
                } elseif (InterestHobbies::DRAWING === $interestHobbie
                    && in_array(
                        InterestHobbies::DRAWING,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Le dessin / La peinture</li>';
                    $count++;
                } elseif (InterestHobbies::GARDENING === $interestHobbie
                    && in_array(
                        InterestHobbies::GARDENING,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Le jardinage</li>';
                    $count++;
                } elseif (InterestHobbies::MODE === $interestHobbie
                    && in_array(
                        InterestHobbies::MODE,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">La mode</li>';
                    $count++;
                } elseif (InterestHobbies::MOVIES === $interestHobbie
                    && in_array(
                        InterestHobbies::MOVIES,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les films</li>';
                    $count++;
                } elseif (InterestHobbies::PICTURES === $interestHobbie
                    && in_array(
                        InterestHobbies::PICTURES,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">La photographies</li>';
                    $count++;
                } elseif (InterestHobbies::PSYCHOLOGY === $interestHobbie
                    && in_array(
                        InterestHobbies::PSYCHOLOGY,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">La psychologie</li>';
                    $count++;
                } elseif (InterestHobbies::READING === $interestHobbie
                    && in_array(
                        InterestHobbies::READING,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">La lecture</li>';
                    $count++;
                } elseif (InterestHobbies::TV === $interestHobbie
                    && in_array(
                        InterestHobbies::TV,
                        $userConnected->getInterestHobbies(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les soirées TV</li>';
                    $count++;
                }
            }

            if ($numberOfCommun) {
                return $count;
            } else {
                return $response;
            }
        }
        
        #[Pure] private function getSports(User $userConnected, User $userMatch, bool $numberOfCommun = false): string|int
        {
            $response = '';
            $count = 0;
            foreach ($userMatch->getInterestSports() as $interestHobbie) {
                if (InterestSports::BASKETBALL === $interestHobbie && in_array(
                        InterestSports::BASKETBALL,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Le basketball</li>';
                    $count++;
                } elseif (InterestSports::BIKE === $interestHobbie && in_array(
                        InterestSports::BIKE,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Le vélo / VTT / Cross</li>';
                    $count++;
                    $count++;
                } elseif (InterestSports::FISHING === $interestHobbie && in_array(
                        InterestSports::FISHING,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">La pêche</li>';
                    $count++;
                } elseif (InterestSports::FITNESS === $interestHobbie && in_array(
                        InterestSports::FITNESS,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Fitness / Musculation</li>';
                    $count++;
                } elseif (InterestSports::FOOTING === $interestHobbie && in_array(
                        InterestSports::FOOTING,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Footing</li>';
                    $count++;
                } elseif (InterestSports::MMA === $interestHobbie && in_array(
                        InterestSports::MMA,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les sports de combat</li>';
                    $count++;
                } elseif (InterestSports::MOTO === $interestHobbie && in_array(
                        InterestSports::MOTO,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">La moto</li>';
                    $count++;
                } elseif (InterestSports::SKI === $interestHobbie && in_array(
                        InterestSports::SKI,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Le ski</li>';
                    $count++;
                } elseif (InterestSports::SOCCER === $interestHobbie && in_array(
                        InterestSports::SOCCER,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Football</li>';
                    $count++;
                } elseif (InterestSports::SPORTCOLLECTIVE === $interestHobbie && in_array(
                        InterestSports::SPORTCOLLECTIVE,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Sports collectifs</li>';
                    $count++;
                } elseif (InterestSports::SPORTDRIVE === $interestHobbie && in_array(
                        InterestSports::SPORTDRIVE,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les sports automobiles</li>';
                    $count++;
                } elseif (InterestSports::SPORTEXTREME === $interestHobbie && in_array(
                        InterestSports::SPORTEXTREME,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les sports extrêmes</li>';
                    $count++;
                } elseif (InterestSports::SWIMMING === $interestHobbie && in_array(
                        InterestSports::SWIMMING,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">La natation</li>';
                    $count++;
                } elseif (InterestSports::TENNIS === $interestHobbie && in_array(
                        InterestSports::TENNIS,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Le tennis</li>';
                    $count++;
                } elseif (InterestSports::TREK === $interestHobbie && in_array(
                        InterestSports::TREK,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les randonnées</li>';
                    $count++;
                } elseif (InterestSports::WALK === $interestHobbie && in_array(
                        InterestSports::WALK,
                        $userConnected->getInterestSports(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">La marche</li>';
                    $count++;
                }
            }

            if ($numberOfCommun) {
                return $count;
            } else {
                return $response;
            }
        }
        
        #[Pure] private function getExists(User $userConnected, User $userMatch, bool $numberOfCommun = false): string|int
        {
            $response = '';
            $count = 0;
            foreach ($userMatch->getInterestExit() as $interestExit) {
                if (InterestExit::CINEMA === $interestExit && in_array(
                        InterestExit::CINEMA,
                        $userConnected->getInterestExit(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Le cinéma</li>';
                    $count++;
                } elseif (InterestExit::CONCERT === $interestExit && in_array(
                        InterestExit::CONCERT,
                        $userConnected->getInterestExit(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Le cinéma</li>';
                    $count++;
                } elseif (InterestExit::CONCERT === $interestExit && in_array(
                        InterestExit::CONCERT,
                        $userConnected->getInterestExit(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les concerts</li>';
                    $count++;
                } elseif (InterestExit::CULTURAL_JOURNEY === $interestExit && in_array(
                        InterestExit::CULTURAL_JOURNEY,
                        $userConnected->getInterestExit(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les journées cuturelles</li>';
                    $count++;
                } elseif (InterestExit::JOURNEY === $interestExit && in_array(
                        InterestExit::JOURNEY,
                        $userConnected->getInterestExit(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les balades (mer, forêt, plage)</li>';
                    $count++;
                } elseif (InterestExit::LOVING_WE === $interestExit && in_array(
                        InterestExit::LOVING_WE,
                        $userConnected->getInterestExit(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les Week-ends en amoureux</li>';
                    $count++;
                } elseif (InterestExit::PARTY === $interestExit && in_array(
                        InterestExit::PARTY,
                        $userConnected->getInterestExit(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les fêtes</li>';
                    $count++;
                } elseif (InterestExit::RESTAURANT === $interestExit && in_array(
                        InterestExit::RESTAURANT,
                        $userConnected->getInterestExit(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les restaurants</li>';
                    $count++;
                } elseif (InterestExit::SHOPPING === $interestExit && in_array(
                        InterestExit::SHOPPING,
                        $userConnected->getInterestExit(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Le shopping</li>';
                    $count++;
                } elseif (InterestExit::SHOW === $interestExit && in_array(
                        InterestExit::SHOW,
                        $userConnected->getInterestExit(),
                        true
                    )) {
                    $response .= '<li class="list-group-item">Les spectacles</li>';
                    $count++;
                }
            }

            if ($numberOfCommun) {
                return $count;
            } else {
                return $response;
            }
        }

        public function isAMatch(User $userConnected, User $match): bool
        {
            return $this->matchManager->isMatch($userConnected, $match);
        }

        public function hasAMatch(User $match): ?array
        {
            return $this->matchManager->hasMatch($match);
        }

        /**
         * Retourne le nombre de point commun entre deux personnes
         */
        public function numberCommunMatch(User $userConnected, User $match): int
        {
            return $this->getExists($userConnected, $match, true) +
                $this->getHobbies($userConnected, $match, true) +
                $this->getSports($userConnected, $match, true);
        }
    }
