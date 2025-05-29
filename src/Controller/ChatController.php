<?php

namespace Chatbot\ChatbotBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Chatbot\ChatbotBundle\Repository\ChatbotFaqRepository;
use Chatbot\ChatbotBundle\Repository\ChatbotCategoryRepository;

class ChatController
{
    #[Route('/chatbot/widget', name: 'chatbot_widget')]
    public function widget(Environment $twig): Response
    {
        return new Response($twig->render('@ChatbotBundle/chatbot_widget.html.twig'));
    }

    #[Route('/chatbot/faqs', name: 'chatbot_faqs')]
    public function getFaqs(ChatbotFaqRepository $chatbotFaqRepository): JsonResponse
    {
        $chatbotFaq = $chatbotFaqRepository->findAll();

        $data = array_map(function ($chatbotFaq) {
            return [
                'id' => $chatbotFaq->getId(),
                'question' => $chatbotFaq->getQuestion(),
                'answer' => $chatbotFaq->getAnswer(),
            ];
        }, $chatbotFaq);

        return new JsonResponse($data);
    }

    #[Route('/chatbot/categories', name: 'chatbot_categories')]
    public function getCategories(ChatbotCategoryRepository $chatbotCategoryRepository): JsonResponse
    {
        $categories = $chatbotCategoryRepository->findAll();

        $data = array_map(function ($category) {
            return [
                'id' => $category->getId(),
                'name' => $category->getName(),
            ];
        }, $categories);

        return new JsonResponse($data);
    }

    #[Route('/chatbot/faqs/{categoryId}', name: 'chatbot_faqs_by_category')]
    public function getFaqsByCategory(
        ChatbotFaqRepository $chatbotFaqRepository,
        int $categoryId
    ): JsonResponse {
        $faqs = $chatbotFaqRepository->findBy(['category' => $categoryId]);

        $data = array_map(function ($faq) {
            return [
                'id' => $faq->getId(),
                'question' => $faq->getQuestion(),
                'answer' => $faq->getAnswer(),
            ];
        }, $faqs);

        return new JsonResponse($data);
    }
}
