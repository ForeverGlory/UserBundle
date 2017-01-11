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

/**
 * Description of AvatarListener
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class AvatarListener implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return [];//array(Events::loadClassMetadata => 'loadClassMetadata');
    }

}
