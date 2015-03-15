<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 07.03.2015
 * Time: 08:18
 */
namespace AppBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;

class Registration {
    /**
     * @Assert\Type(type="AppBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    /**
     * @Assert\Type(type="AppBundle\Entity\Role")
     * @Assert\Valid()
     */
    protected $role;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setRole(Role $role) {
        $this->role = $role;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (Boolean) $termsAccepted;
    }
}