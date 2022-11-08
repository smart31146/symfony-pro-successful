<?php

namespace AppBundle\Entity;

/**
 * Role
 */
class Role
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Role
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $user->addAccessRole($this);
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->accesses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $accesses;

    /**
     * Add access
     *
     * @param \AppBundle\Entity\Access $accesses
     *
     * @return Role
     */
    public function addAccess(\AppBundle\Entity\Access $access)
    {
        $access->setRole($this);
        $this->accesses[] = $access;

        return $this;
    }

    /**
     * Remove access
     *
     * @param \AppBundle\Entity\Access $access
     */
    public function removeAccess(\AppBundle\Entity\Access $access)
    {
        $this->accesses->removeElement($access);
    }

    /**
     * Get accesses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccesses()
    {
        return $this->accesses;
    }
}
