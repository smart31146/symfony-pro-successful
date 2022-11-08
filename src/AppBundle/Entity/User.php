<?php

namespace AppBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User implements UserInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $accessRoles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->accessRoles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return md5(random_bytes(50));
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add accessRole
     *
     * @param \AppBundle\Entity\Role $accessRole
     *
     * @return User
     */
    public function addAccessRole(\AppBundle\Entity\Role $accessRole)
    {
        $this->accessRoles[] = $accessRole;

        return $this;
    }

    /**
     * Remove accessRole
     *
     * @param \AppBundle\Entity\Role $accessRole
     */
    public function removeAccessRole(\AppBundle\Entity\Role $accessRole)
    {
        $this->accessRoles->removeElement($accessRole);
    }

    public function getProjects()
    {
        $projects = [];

        $roles = $this->getAccessRoles();
        foreach ($roles as $role) {
            $accesses = $role->getAccesses();
            foreach ($accesses as $access) {
                $values = $access->getProjects()->getValues();
                foreach ($values as $value) {
                    if (!in_array($value, $projects, true)) {
                        $projects[] = $value;
                    }
                }
            }
        }

        return $projects;
    }

    public function getProjectsByAccess()
    {
        $projects = [
            Access::DELETE => [],
            Access::WRITE => [],
            Access::READ => []
        ];
        $roles = $this->getAccessRoles();
        foreach ($roles as $role) {
            $accesses = $role->getAccesses();
            foreach ($accesses as $access) {
                $values = $access->getProjects()->getValues();
                foreach ($values as $value) {
                    $projects[$access->getType()][] = $value;
                }
            }
        }

        return $projects;
    }

    /**
     * Get accessRoles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccessRoles()
    {
        return $this->accessRoles;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->securityRoles;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }


    /**
     * @var array
     */
    private $securityRoles;


    /**
     * Set securityRoles
     *
     * @param array $securityRoles
     *
     * @return User
     */
    public function setSecurityRoles($securityRoles)
    {
        $this->securityRoles = $securityRoles;

        return $this;
    }

    /**
     * Get securityRoles
     *
     * @return array
     */
    public function getSecurityRoles()
    {
        return $this->securityRoles;
    }
}
