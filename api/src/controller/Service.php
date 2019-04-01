<?php

class Service {
    protected $view;
    
    public function __construct() {
        
    }

    /**
     * Media nacional e ex alunos que ainda estudam
     */
    public function getMediaNacional(){
        global $container, $em;

        try{
            $container->db;
            $oStudentsSim = $em->getRepository('Entidades\Answers')->findBy( array('alternativeId' => 37) ); 
            $oStudentsTotal = $em->getRepository('Entidades\Answers')->findAll(); 

            $count = sizeof($oStudentsSim) / sizeof($oStudentsTotal) * 100;

            return $count;
        } catch (\Exception $e) {
            $container->logger->error( __CLASS__ . ' - ' . $e->getMessage() );
        }   
    }

    /**
     * Retorna todos alunos por regiao, com indicador se estuda ou nao
     */
    public function getByState($indEstuda){
        global $container, $em;

        $qb 	= $em->createQueryBuilder();
        try {
			$qb->select('s.regional as description, count(a.id) as alunos')
            ->from('Entidades\Answers','a')
            ->leftJoin('Entidades\Students', 's', \Doctrine\ORM\Query\Expr\Join::WITH, 'a.studentId = s.id')
			->where(
                $qb->expr()->eq('a.alternativeId', ':indEstuda')
            )
            ->setParameter('indEstuda', $indEstuda)
            ->groupBy('s.regional');
			
			$query 		= $qb->getQuery();
            return($query->getResult());

        } catch (\Exception $e) {
            $container->logger->error( __CLASS__ . ' - ' . $e->getMessage() );
        }  
    }
}