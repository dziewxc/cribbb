<?php namespace Cribbb\Users;

use Cribbb\Cribbbs\Cribbb;
use Cribbb\Users\Email\Email;
use Doctrine\ORM\Mapping as ORM;
use Cribbb\Users\Username\Username;
use Cribbb\Users\Password\Password;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User {

  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string")
   */
  private $email;

  /**
   * @ORM\Column(type="string")
   */
  private $username;

  /**
   * @ORM\Column(type="string")
   */
  private $password;

  /**
   * @ORM\ManyToMany(targetEntity="Cribbb\Cribbbs\Cribbb", mappedBy="users")
   */
  private $cribbbs;

  /**
   * Create a new User instance
   *
   * @param Cribbb\Users\Email\Email $email
   * @param Cribbb\Users\Username\Username $username
   * @param Cribbb\Users\Password\Password $password
   * @return void
   */
  public function __construct(Email $email, Username $username, Password $password)
  {
    $this->setEmail($email);
    $this->setUsername($username);
    $this->setPassword($password);

    $this->cribbbs = new ArrayCollection();
  }

  /**
   * Get the User's id
   *
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Get the User's email address
   *
   * @return string
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the User's email address
   *
   * @param Cribbb\Users\Email\Email $email
   * @return void
   */
  public function setEmail(Email $email)
  {
    $this->email = $email;
  }

  /**
   * Get the User's username
   *
   * @return string
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * Set the User's username
   *
   * @param Cribbb\Users\Username\Username
   * @return void
   */
  public function setUsername(Username $username)
  {
    $this->username = $username;
  }

  /**
   * Get the User's password
   *
   * @return string
   */
  public function getPassword()
  {
    return $this->username;
  }

  /**
   * Set the User's password
   *
   * @param Cribbb\Users\Password\Password
   * @return void
   */
  public function setPassword(Password $password)
  {
    $this->password = $password;
  }

  /**
   * Add the user to a Cribbb
   *
   * @param Cribbb\Cribbbs\Cribbb $cribbb
   * @return void
   */
  public function addToCribbb(Cribbb $cribbb)
  {
    $cribbb->addUser($this);

    $this->cribbbs[] = $cribbb;
  }

}