<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author ForeverGlory <foreverglory@qq.com>
 */
class CreateGroupCommand extends ContainerAwareCommand
{

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
                ->setName('glory:user:create-group')
                ->setDescription('Create a group.')
                ->setDefinition(array(
                    new InputArgument('name', InputArgument::REQUIRED, 'The name')
                ))
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $groupManager = $this->getContainer()->get('glory_user.group_manager');
        $group = $groupManager->createGroup($name);
        $groupManager->updateGroup($group);
        $output->writeln(sprintf('Created group <comment>%s</comment> success', $name));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('name')) {
            $name = $this->getHelper('dialog')->askAndValidate(
                    $output, 'Please choose a name:', function($name) {
                if (empty($name)) {
                    throw new \Exception('Name can not be empty');
                }

                return $name;
            }
            );
            $input->setArgument('name', $name);
        }
    }

}
