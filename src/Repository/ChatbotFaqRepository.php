<?php

namespace Chatbot\ChatbotBundle\Repository;

use Chatbot\ChatbotBundle\Entity\ChatbotFaq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ChatbotFaqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatbotFaq::class);
    }
}
