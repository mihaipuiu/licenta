<?php
namespace App\Controller;

use App\Entity\RoomOccupation;
use App\Entity\User;
use App\Exception\InvalidDataClassException;
use App\FormGenerator\ChangeAccountPasswordFormGenerator;
use App\FormGenerator\EditAccountDetailsFormGenerator;
use App\Repository\RoomOccupationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends BaseController
{
    public static array $mappedSuccessMessages = [
        'edit-account-details' => 'You have successfully updated your profile details.',
        'change-password' => 'You have successfully updated your account password.',
        'cancel-booking' => 'You have successfully canceled the booking'
    ];

    public static array $mappedFailedMessages = [
        'edit_account_details' => 'For some reason, profile details failed to save. Please check your inputs are correct.',
        'change-password' => 'For some reason, we failed to update your account password. Please check your inputs are correct.',
        'cancel-booking' => 'For some reason, booking cancellation failed. Please try again later.',
    ];

    /**
     * @Route(path="user/account", name="user_account")
     *
     * @param Request $request
     * @param ChangeAccountPasswordFormGenerator $changeAccountPasswordFormGenerator
     * @param EditAccountDetailsFormGenerator $editAccountDetailsFormGenerator
     *
     * @return RedirectResponse|Response
     *
     * @throws InvalidDataClassException
     */
    public function accountDetails(Request $request, ChangeAccountPasswordFormGenerator $changeAccountPasswordFormGenerator, EditAccountDetailsFormGenerator $editAccountDetailsFormGenerator, RoomOccupationRepository $repository)
    {
        if (empty($this->getUser()) || !($this->getUser() instanceof User)) {
            return $this->redirectToRoute('index');
        }

        $editDetailsForm = $editAccountDetailsFormGenerator
            ->generateForm($this->getUser())
            ->setAction($this->generateUrl('user_edit_details'))
            ->setMethod(Request::METHOD_POST)
            ->getForm()
        ;

        $changePasswordForm = $changeAccountPasswordFormGenerator
            ->generateForm()
            ->setAction($this->generateUrl('user_change_password'))
            ->setMethod(Request::METHOD_POST)
            ->getForm()
        ;

        /** @var User $user */
        $user = $this->getUser();

        $success = !empty($request->query->all()['success']);
        $message = !empty($request->query->all()['message']) ? $request->query->all()['message'] : (!empty($request->query->all()['action']) ? !empty($success) ? self::$mappedSuccessMessages[$request->query->all()['action']] : self::$mappedFailedMessages[$request->query->all()['action']] : '');

        return $this->render('user/account_details.html.twig', [
            'subTitle' => 'Account Details',
            'searchForm' => $this->getSearchForm()->createView(),
            'editDetailsForm' => $editDetailsForm->createView(),
            'changePasswordForm' => $changePasswordForm->createView(),
            'user' => $user,
            'roomOccupations' => $repository->findBy(['user' => $user], ['startDate' => 'DESC']),
            'message' => $message,
            'success' => $success,
        ]);
    }

    /**
     * @Route(path="user/account/cancel_book/{id}", name="cancel_booking")
     */
    public function cancelBooking(RoomOccupation $roomOccupation, EntityManagerInterface $entityManager)
    {
        /** @var User $user */
        $user = $this->getUser();
        if($roomOccupation->getUser()->getId() == $user->getId()) {
            $entityManager->remove($roomOccupation);
            $entityManager->flush();
            return $this->redirectToRoute('user_account', ['_fragment' => 'my-bookings', 'success' => true, 'action' => 'cancel-booking']);
        }

        return $this->redirectToRoute('user_account', ['_fragment' => 'my-bookings', 'success' => false, 'action' => 'cancel-booking']);
    }

    /**
     * @Route(path="user/account/change_password", name="user_change_password", methods={"POST"})
     *
     * @param Request $request
     * @param ChangeAccountPasswordFormGenerator $changeAccountPasswordFormGenerator
     * @param EntityManagerInterface $entityManager
     *
     * @return RedirectResponse
     */
    public function changePassword(Request $request, ChangeAccountPasswordFormGenerator $changeAccountPasswordFormGenerator, EntityManagerInterface $entityManager)
    {
        if (empty($this->getUser()) || !($this->getUser() instanceof User)) {
            return $this->redirect('index');
        }

        $changePasswordForm = $changeAccountPasswordFormGenerator
            ->generateForm($this->getUser())
            ->setAction($this->generateUrl('user_change_password'))
            ->setMethod(Request::METHOD_POST)
            ->getForm()
        ;

        $changePasswordForm->handleRequest($request);

        if($changePasswordForm->isSubmitted()) {
            $data = $changePasswordForm->getData();
            if($this->getUser()->getPassword() != md5($data['old_password'])) {
                $changePasswordForm->addError(new FormError('Invalid password'));
            }
            if($changePasswordForm->isValid()) {
                /** @var User $user */
                $user = $this->getUser();
                $user->setPassword(md5($data['new_password']));
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('user_account', ['success' => true, 'action' => 'change-password']);
            } else {
                foreach($changePasswordForm->getErrors(true) as $error) {
                    return $this->redirectToRoute('user_account', ['_fragment' => 'change-password', 'success' => false, 'action' => 'change-password', 'message' => $error->getMessage()]);
                }
            }
        }

        return $this->redirect('user_account');
    }

    /**
     * @Route(path="user/account/edit_account_details", name="user_edit_details", methods={"POST"})
     *
     * @param Request $request
     * @param EditAccountDetailsFormGenerator $editAccountDetailsFormGenerator
     * @param EntityManagerInterface $entityManager
     *
     * @return RedirectResponse
     *
     * @throws InvalidDataClassException
     */
    public function changeAccountDetails(Request $request, EditAccountDetailsFormGenerator $editAccountDetailsFormGenerator, EntityManagerInterface $entityManager)
    {
        if (empty($this->getUser()) || !($this->getUser() instanceof User)) {
            return $this->redirectToRoute('index');
        }

        $editDetailsForm = $editAccountDetailsFormGenerator
            ->generateForm($this->getUser())
            ->setAction($this->generateUrl('user_edit_details'))
            ->setMethod(Request::METHOD_POST)
            ->getForm()
        ;

        $editDetailsForm->handleRequest($request);

        if($editDetailsForm->isSubmitted() && $editDetailsForm->isValid()) {
            try {
                $entityManager->persist($editDetailsForm->getData());
                $entityManager->flush();
            } catch (\Exception $exception) {
                return $this->redirectToRoute('user_account', ['_fragment' => 'edit-account-details', 'success' => false, 'action' => 'edit-account-details']);
            }
        }

        return $this->redirectToRoute('user_account', ['_fragment' => 'edit-account-details', 'success' => true, 'action' => 'edit-account-details']);
    }
}