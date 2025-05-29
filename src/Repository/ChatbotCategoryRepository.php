<?php
namespace Chatbot\ChatbotBundle\Repository;

use Chatbot\ChatbotBundle\Entity\ChatbotCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ChatbotCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatbotCategory::class);
    }
}
