<?php
namespace Hautelook\AliceBundle\Alice;

use Nelmio\Alice\ORM\Doctrine as BaseDoctrine;

/**
 * Class Doctrine - Adapter for Doctrine ORM
 * @author Baldur Rensch <brensch@gmail.com>
 */
class Doctrine extends BaseDoctrine
{
    /**
     * Detaches an entity
     *
     * @param mixed $obj
     */
    public function detach($obj)
    {
        $this->om->detach($obj);
    }

    /**
     * Merges an entity
     *
     * @param $obj
     *
     * @return object
     */
    public function merge($obj)
    {
        return $this->om->merge($obj);
    }
}
