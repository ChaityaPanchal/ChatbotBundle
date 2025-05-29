<?php
namespace Chatbot\ChatbotBundle\Controller;

use Chatbot\ChatbotBundle\Entity\ChatbotCategory;
use Chatbot\ChatbotBundle\Form\ChatbotCategoryType;
use Chatbot\ChatbotBundle\Repository\ChatbotCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('chatbot/category')]
#[IsGranted('ROLE_ADMIN')]
class ChatbotCategoryController extends AbstractController
{
    #[Route('/', name: 'chatbot_category_index')]
    public function index(ChatbotCategoryRepository $categoryRepository): Response
    {
        return $this->render('@Chatbot/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'chatbot_category_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $category = new ChatbotCategory();
        $form = $this->createForm(ChatbotCategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('chatbot_category_index');
        }
        return $this->render('@Chatbot/category/form.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'chatbot_category_edit')]
    public function edit(ChatbotCategory $category, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ChatbotCategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('chatbot_category_index');
        }

        return $this->render('@Chatbot/category/form.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }

    #[Route('/{id}/delete', name: 'chatbot_category_delete')]
    public function delete(ChatbotCategory $category, EntityManagerInterface $em): Response
    {
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('chatbot_category_index');
    }
}
