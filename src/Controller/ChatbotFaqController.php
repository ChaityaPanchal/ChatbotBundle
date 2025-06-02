<?php

namespace Chatbot\Controller;

use Chatbot\Entity\ChatbotFaq;
use Chatbot\Form\ChatbotFaqType;
use Chatbot\Repository\ChatbotFaqRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/faq')]
class ChatbotFaqController extends AbstractController
{
    private ChatbotFaqRepository $chatbotFaqRepository;
    private EntityManagerInterface $em;
    private string $requiredRole;
    public function __construct(
        ChatbotFaqRepository $chatbotFaqRepository,
        EntityManagerInterface $em,
        string $requiredRole
    ){
        $this->chatbotFaqRepository = $chatbotFaqRepository;
        $this->em = $em;
        $this->requiredRole = $requiredRole;
    }
    #[Route('/', name: 'chatbot_faq_index')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted($this->requiredRole);
        return $this->render('@Chatbot/faq/index.html.twig', [
            'faqs' => $this->chatbotFaqRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'chatbot_faq_new')]
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted($this->requiredRole);
        $faq = new ChatbotFaq();
        $form = $this->createForm(ChatbotFaqType::class, $faq);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($faq);
            $this->em->flush();

            return $this->redirectToRoute('chatbot_faq_index');
        }

        return $this->render('@Chatbot/faq/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add New FAQ'
        ]);
    }

    #[Route('/{id}/edit', name: 'chatbot_faq_edit')]
    public function edit(ChatbotFaq $faq, Request $request): Response
    {
        $this->denyAccessUnlessGranted($this->requiredRole);
        $form = $this->createForm(ChatbotFaqType::class, $faq);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('chatbot_faq_index');
        }

        return $this->render('@Chatbot/faq/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit FAQ'
        ]);
    }

    #[Route('/{id}/delete', name: 'chatbot_faq_delete')]
    public function delete(Request $request, ChatbotFaq $faq): Response
    {
        $this->denyAccessUnlessGranted($this->requiredRole);
        $csrfToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete-faq' . $faq->getId(), $csrfToken)) {
            $this->em->remove($faq);
            $this->em->flush();
        } else {
            $this->addFlash('error', 'Invalid CSRF token.');
        }

        return $this->redirectToRoute('chatbot_faq_index');
    }
}
