<?php

declare(strict_types=1);

namespace MauticPlugin\SCCronBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetSegmentsCommand extends ContainerAwareCommand
{
    private SymfonyStyle $io;


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('sc:cron:segments')
            ->setDescription('Get the segments ids to run in the cron'); 

        parent::configure();
    }

        /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $this->io  = new SymfonyStyle($input, $output);
        $listModel = $container->get('mautic.lead.model.list');
        $leadLists = $listModel->getEntities(
            [                
                'orderBy'    => 'l.lastBuiltDate',
                'orderByDir' => 'desc',
                'iterator_mode' => true,
                'limit' => 10
            ]
        );

        $segmentsToBeBuilt = [];
        while (false !== ($leadList = $leadLists->next())) {
            // Get first item; using reset as the key will be the ID and not 0
            /** @var LeadList $leadList */
            $leadList = reset($leadList);
            if ($leadList->isPublished()) {        
                array_push($segmentsToBeBuilt, $leadList->getId());

            }
        }
        echo implode(',', $segmentsToBeBuilt) . "\n";        
    }   
}