<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Glory\Bundle\UserBundle\Model\Group as BaseGroup;

/**
 * Group entity
 *
 * @ORM\MappedSuperclass
 * 
 * @author ForeverGlory <foreverglory@qq.com>
 */
abstract class AbstractGroup extends BaseGroup
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct($name, $roles = array())
    {
        parent::__construct($name, $roles);
    }

}
