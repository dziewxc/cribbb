<?php namespace Cribbb\Domain\Model\Identity;

use Cribbb\Domain\HasEvents;
use Doctrine\ORM\Mapping as ORM;
use Cribbb\Domain\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Cribbb\Domain\Model\Identity\Events\PasswordWasReset;
use Cribbb\Domain\Model\Identity\Events\UserHasRegistered;
use Cribbb\Domain\Model\Identity\Events\UsernameWasUpdated;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements AggregateRoot
{
    use HasEvents;

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
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
     * Create a new User
     *
     * @param UserId $userId
     * @param Email $email
     * @param Username $username
     * @param HashedPassword $password
     * @return void
     */
    private function __construct(UserId $userId, Email $email, Username $username, HashedPassword $password)
    {
        $this->setId($userId);
        $this->setEmail($email);
        $this->setUsername($username);
        $this->setPassword($password);

        $this->record(new UserHasRegistered($this));
    }

    /**
     * Register a new User
     *
     * @param UserId $userId
     * @param Email $email
     * @param Username $username
     * @param HashedPassword $password
     * @return User
     */
    public static function register(UserId $userId, Email $email, Username $username, HashedPassword $password)
    {
        $user = new User($userId, $email, $username, $password);

        return $user;
    }

    /**
     * Get the User's id
     *
     * @return UserId;
     */
    public function id()
    {
        return UserId::fromString($this->id);
    }

    /**
     * Set the User's id
     *
     * @param UserId $id
     * @return void
     */
    private function setId(UserId $id)
    {
        $this->id = $id->toString();
    }

    /**
     * Get the User's email address
     *
     * @return string
     */
    public function email()
    {
        return Email::fromNative($this->email);
    }

    /**
     * Set the User's email address
     *
     * @param Email $email
     * @return void
     */
    private function setEmail(Email $email)
    {
        $this->email = $email->toString();
    }

    /**
     * Get the User's username
     *
     * @return string
     */
    public function username()
    {
        return Username::fromNative($this->username);
    }

    /**
     * Set the User's username
     *
     * @param Username $username
     * @return void
     */
    private function setUsername(Username $username)
    {
        $this->username = $username->toString();
    }

    /**
     * Update a User' username
     *
     * @param Username $username
     * @return void
     */
    public function updateUsername(Username $username)
    {
        $this->setUsername($username);

        $this->record(new UsernameWasUpdated($this));
    }

    /**
     * Set the User's password
     *
     * @param HashedPassword $password
     * @return void
     */
    private function setPassword(HashedPassword $password)
    {
        $this->password = $password->toString();
    }

    /**
     * Reset the User's password
     *
     * @param HashedPassword $password
     * @return void
     */
    public function resetPassword(HashedPassword $password)
    {
        $this->password = $password;

        $this->record(new PasswordWasReset($this));
    }
}
