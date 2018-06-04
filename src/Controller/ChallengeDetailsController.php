<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\Comment;
use App\Entity\Milestone;
use App\Form\CommentForm;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChallengeDetailsController extends Controller
{
    /**
     * @param int $id
     * @Route("/challenge/details/{id}", name="challenge_details")
     * @return Response|RedirectResponse
     */
    public function index(int $id)
    {
        $em = $this->getDoctrine()->getRepository('Challenge.php');
        $challenge = $em->find($id);

        if (($challenge->getOwner() !== $this->getUser()) && $challenge->getPublic() === false) {
            return $this->redirectToRoute('my_challenges');
        }

        $em = $this->getDoctrine()->getRepository('App:Milestone');
        /** @var Milestone $milestones */
        $milestones = $em->getMilestonesByChallengeAndUser($challenge, $this->getUser());

        $em = $this->getDoctrine()->getRepository('App:Comment');
        $comments = $em->getChallengeComments($challenge);

        return $this->render('challenge_details/index.html.twig', [
            'controller_name'  => 'ChallengeDetailsController',
            'challenge'        => $challenge,
            'milestones'       => $milestones,
            'comments'         => $comments
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @Route("comment/challenge/{id}", name="post_comment_form")
     * @return Response|RedirectResponse
     */
    public function commentFormRender(Request $request, int $id)
    {
        $challenge = $this->getDoctrine()->getRepository('Challenge.php')->find($id);

        if (!$challenge->getPublic() && $challenge->getOwner() !== $this->getUser()) {
            return $this->redirectToRoute('my_challenges');
        }

        $newCommentOrRedirect = $this->newComment($request, $id);

        if ($newCommentOrRedirect instanceof RedirectResponse) {
            return $newCommentOrRedirect;
        }

        return $this->render('comment_form/index.html.twig', [
            'controller_name' => 'ChallengeDetailsController',
            'form'            => $newCommentOrRedirect,
            'challengeId'     => $id,
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return FormView|RedirectResponse
     */
    private function newComment(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getRepository('Challenge.php');
        $challenge = $em->find($id);

        $comment = new Comment();
        $comment->setPostedOn(new \DateTime('now'));
        $comment->setUser($this->getUser());
        $comment->setChallenge($challenge);

        $form = $this->createForm(CommentForm::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('challenge_details', ['id' => $id]);
        }

        return $form->createView();
    }
}
