<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\UserBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

/**
 * Description of DoctrineListener
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class DoctrineListener implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist => 'postPersist',
            Events::loadClassMetadata => 'loadClassMetadata'
        );
    }
    
    public function postPersist($param)
    {
        
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        $classMetadata = $args->getClassMetadata();
        if ($classMetadata->getName() == 'Merula\FrameworkBundle\Entity\Profile') {
            
        }
    }

}
