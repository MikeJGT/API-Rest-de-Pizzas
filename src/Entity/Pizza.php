<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
// use ApiPlatform\Metadata\Put;

use App\Repository\PizzaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeImmutable;


#[ORM\Entity(repositoryClass: PizzaRepository::class)]
#[ApiResource(
    description: 'An Api with the best Pizzas.',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        //Uncomment the next line to allow the PUT method. 
        // new Put(),
        new Patch(),
        new Delete(),
    ]
)]
class Pizza
{
 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;


    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 48)]
    private ?string $name = null;
 
    
    #[Assert\NotBlank]
    #[Assert\Count(
        min:1,
        max: 20,
        minMessage: 'You cannot specify less than 1 ingredients',
        maxMessage: 'You cannot specify more than {{ limit }} ingredients',
    )]
    #[ORM\Column(type: Types::JSON)]
    private array $ingredients = [];

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $ovenTimeInSeconds = null;

    /**
     * This field is created automatically when a new Pizza is created on POST (or replaced compleatly on PUT).
     */
    #[Assert\NotBlank]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    /**
     * This field is updated automatically on POST and PATCH.
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * This field just can be setted when a new Pizza is created, POST method.
     */
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $special;

   
    public function __construct(bool $special)
    {
        $this->special =  $special;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->setUpdatedAt();
        $this->name = $name;

        return $this;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients): static
    {

        $this->setUpdatedAt();
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getOvenTimeInSeconds(): ?int
    {
        return $this->ovenTimeInSeconds;
    }

    public function setOvenTimeInSeconds(?int $ovenTimeInSeconds): static
    {   
        $this->setUpdatedAt();
        $this->ovenTimeInSeconds = $ovenTimeInSeconds;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    private function setUpdatedAt(): static
    {
        $formatTime='Y-m-d H:i:s';
        $updatedTime = new DateTimeImmutable();

        if($this->createdAt->format($formatTime) != $updatedTime->format($formatTime))
        {
            $this->updatedAt = $updatedTime;
        }
    
        return $this;
    }

    public function getSpecial(): bool
    {
        return $this->special;
    }
}
