<?php

namespace Chatbot\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Chatbot\Repository\ChatbotFaqRepository;
use Chatbot\Repository\ChatbotCategoryRepository;
use Chatbot\Entity\ChatbotCategory;

class ChatController extends AbstractController
{
    private ChatbotFaqRepository $chatbotFaqRepository;
    private ChatbotCategoryRepository $chatbotCategoryRepository;
    public function __construct(
        ChatbotFaqRepository $chatbotFaqRepository,
        ChatbotCategoryRepository $chatbotCategoryRepository,
    ){
        $this->chatbotFaqRepository = $chatbotFaqRepository;
        $this->chatbotCategoryRepository = $chatbotCategoryRepository;
    }
    #[Route('/widget', name: 'chatbot_widget')]
    public function widget(): Response
    {
        return $this->render('@Chatbot/chatbot_widget.html.twig');
    }

    #[Route('/faqs', name: 'chatbot_faqs')]
    public function getFaqs(): JsonResponse
    {
        $chatbotFaq = $this->chatbotFaqRepository->findAll();

        $faqList = array_map(fn($faq) => [
            'id' => $faq->getId(),
            'question' => $faq->getQuestion(),
            'answer' => $faq->getAnswer(),
        ], $chatbotFaq);

        return $this->json($faqList);
    }

    #[Route('/categories', name: 'chatbot_categories')]
    public function getCategories(): JsonResponse
    {
        $categories = $this->chatbotCategoryRepository->findAll();

        $categoryList = array_map(fn($category) => [
            'id' => $category->getId(),
            'name' => $category->getName(),
        ], $categories);

        return $this->json($categoryList);
    }

    #[Route('/faqs/{category}', name: 'chatbot_faqs_by_category')]
    public function getFaqsByCategory( ChatbotCategory $category ): JsonResponse {
        $faqsByCategory = $category->getFaqs()->toArray();

        $faqList = array_map(fn($faq) => [
            'id' => $faq->getId(),
            'question' => $faq->getQuestion(),
            'answer' => $faq->getAnswer(),
        ], $faqsByCategory);

        return $this->json($faqList);
    }
}
