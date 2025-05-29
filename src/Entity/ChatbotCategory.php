<?php
namespace Chatbot\ChatbotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: 'Chatbot\ChatbotBundle\Repository\ChatbotCategoryRepository')]
class ChatbotCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: ChatbotFaq::class, cascade: ['persist', 'remove'])]
    private Collection $faqs;

    public function __construct()
    {
        $this->faqs = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getFaqs(): Collection
    {
        return $this->faqs;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
