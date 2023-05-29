<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\DeletedTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\SlugTrait;
use App\Enum\UserModeEnum;
use App\Factories\PhoneFactory;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @class User
 *
 * @property int $id
 * @property DateTime $createdAt
 * @property string $slug
 * @property bool $deleted
 * @property string $email
 * @property array $roles
 * @property string $password
 * @property string $name
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    use IdTrait;
    use CreatedAtTrait;
    use SlugTrait;
    use DeletedTrait;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, options: ['default' => 0.00])]
    private ?float $balance;

    #[ORM\Column(length: 180, unique: true)]
    private string $email;

    #[ORM\Column(length: 180)]
    private ?string $name;

    #[ORM\Column(type: 'bigint', unique: true)]
    private int $phone;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(type: 'smallint')]
    private int $mode;

    /**
     * @var string|null The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }

    /**
     * @param string $phone
     * @param string $email
     * @param string $name
     * @param string $role
     * @return User
     */
    public static function make(
        string $phone,
        string $email,
        string $name = '',
        string $role = self::ROLE_USER,
    ): User
    {
        $user = new self;
        $user->setPhone($phone);
        $user->setEmail($email);
        $user->setName($name);
        $user->setRoles([$role]);
        $user->setSlug(md5($phone));
        $user->setMode(UserModeEnum::webmaster->value);

        return $user;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->name ?? $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
//        $roles[] = self::ROLE_USER;
//        $roles[] = self::ROLE_ADMIN;

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return in_array(self::ROLE_ADMIN, $this->getRoles());
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        return in_array(self::ROLE_USER, $this->getRoles()) || $this->isAdmin();
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return PhoneFactory::intToPhone($this->phone);
    }

    /**
     * @param int $phone
     */
    public function setPhone(int $phone): void
    {
        $this->phone = PhoneFactory::phoneToInt($phone);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param float $balance
     */
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @param int $mode
     */
    public function setMode(int $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * @return int
     */
    public function getMode(): int
    {
        return $this->mode;
    }

    /**
     * @return bool
     */
    public function isWebmaster(): bool
    {
        return $this->mode == UserModeEnum::webmaster->value;
    }
}
