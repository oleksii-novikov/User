<?php

namespace User\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * An example of how to implement a role aware user entity.
 *
 * @ORM\Entity(repositoryClass="User\Repository\User")
 * @ORM\Table(name="users")
 *
 * @author Oleksii Novikov
 */
class User
{
    const ROLE_USER = 'user';

    const ROLE_ADMIN = 'admin';

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_UNCONFIRMED = 'unconfirmed';

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true,  length=255)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $displayName;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $salt;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, options={"default" = "user"})
     */
    protected $role;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, options={"default" = null})
     */
    protected $confirm;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable=false, columnDefinition="ENUM('active','inactive','unconfirmed')", options={"default" = "unconfirmed"})
     */
    protected $status;

    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     *
     * @return void
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get salt.
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set salt.
     *
     * @param string salt
     *
     * @return void
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get role.
     *
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set role.
     *
     * @param int $role
     *
     * @return void
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getConfirm()
    {
        return $this->confirm;
    }

    /**
     * @param $confirm
     */
    public function setConfirm($confirm)
    {
        $this->confirm = $confirm;
    }

    /**
     * @return string
     */
    public function generateConfirm()
    {
        return md5($this->getUsername() . microtime(false) . $this->getSalt());
    }

    /**
     * @return $this
     */
    public function activate()
    {
        $this->setStatus(self::STATUS_ACTIVE);
        $this->setConfirm(null);

        return $this;
    }
}
