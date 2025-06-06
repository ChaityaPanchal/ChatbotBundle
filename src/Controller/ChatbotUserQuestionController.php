<?php
// src/Controller/ChatbotUserQuestionController.php
namespace Chatbot\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserQuestion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Chatbot\Security\ChatbotUserInterface;

class ChatbotUserQuestionController extends AbstractController
{
    private string $requiredRole;
    private EntityManagerInterface $entityManager;

    public function __construct(string $requiredRole, EntityManagerInterface $entityManager)
    {
        $this->requiredRole = $requiredRole;
        $this->em = $entityManager;
    }

    #[Route('/user-questions', name: 'chatbot_user_questions_index')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted($this->requiredRole);
        $questions = $this->em->getRepository(UserQuestion::class)->findAll();
        return $this->render('@Chatbot/user_questions/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    #[Route('/{id}/delete', name: 'chatbot_user_question_delete')]
    public function delete(UserQuestion $question): Response
    {
        $this->em->remove($question);
        $this->em->flush();
        $this->addFlash('success', 'Question deleted.');
        return $this->redirectToRoute('chatbot_user_questions_index');
    }

    #[Route('/submit-user-question', name: 'chatbot_submit_user_question', methods: ['POST'])]
    public function submitUserQuestion(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!isset($data['question']) || empty(trim($data['question']))) {
                return new JsonResponse(['error' => 'Question is required'], 400);
            }

            $questionText = trim($data['question']);
            $user = $this->getUser();

            if (!$user instanceof ChatbotUserInterface) {
                return new JsonResponse(['error' => 'Invalid user'], 403);
            }

            $userQuestion = new UserQuestion();
            $userQuestion->setQuestionText($questionText);
            $userQuestion->setUser($user);

            $this->em->persist($userQuestion);
            $this->em->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Question submitted successfully'
            ]);

        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Failed to submit question: ' . $e->getMessage()
            ], 500);
        }
    }

}
