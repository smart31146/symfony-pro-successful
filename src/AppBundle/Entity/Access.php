<?php

namespace AppBundle\Entity;

/**
 * Access
 */
class Access
{
    public const DELETE = 0;
    public const WRITE = 1;
    public const READ = 2;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $type;


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $projects;

    /**
     * Constructor
     */
    public function __construct($type = null)
    {
        if (null !== $type) {
            $this->type = $type;
        }
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set type
     *
     * @param integer $type
     *
     * @return Access
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Access
     */
    public function addProject(\AppBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param \AppBundle\Entity\Project $project
     */
    public function removeProject(\AppBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @var \AppBundle\Entity\Role
     */
    private $role;

    /**
     * Set role
     *
     * @param \AppBundle\Entity\Role $role
     *
     * @return Access
     */
    public function setRole(\AppBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \AppBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
