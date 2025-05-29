<?php

namespace Chatbot\ChatbotBundle\Controller;

use Chatbot\ChatbotBundle\Entity\ChatbotFaq;
use Chatbot\ChatbotBundle\Form\ChatbotFaqType;
use Chatbot\ChatbotBundle\Repository\ChatbotFaqRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/chatbot/faq')]
#[IsGranted('ROLE_ADMIN')]
class ChatbotFaqController extends AbstractController
{
    #[Route('/', name: 'chatbot_faq_index')]
    public function index(ChatbotFaqRepository $faqRepository): Response
    {
        return $this->render('@Chatbot/faq/index.html.twig', [
            'faqs' => $faqRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'chatbot_faq_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $faq = new ChatbotFaq();
        $form = $this->createForm(ChatbotFaqType::class, $faq);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($faq);
            $em->flush();

            return $this->redirectToRoute('chatbot_faq_index');
        }

        return $this->render('@Chatbot/faq/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add New FAQ'
        ]);
    }

    #[Route('/{id}/edit', name: 'chatbot_faq_edit')]
    public function edit(ChatbotFaq $faq, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ChatbotFaqType::class, $faq);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('chatbot_faq_index');
        }

        return $this->render('@Chatbot/faq/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit FAQ'
        ]);
    }

    #[Route('/{id}/delete', name: 'chatbot_faq_delete')]
    public function delete(ChatbotFaq $faq, EntityManagerInterface $em): Response
    {
        $em->remove($faq);
        $em->flush();

        return $this->redirectToRoute('chatbot_faq_index');
    }
}
