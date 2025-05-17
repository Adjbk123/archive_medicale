<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\User;
use App\Form\PatientType;
use App\Repository\DossierMedicalRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/patient')]
class PatientController extends AbstractController
{
    #[Route('/', name: 'app_patient_index', methods: ['GET'])]
    public function index(PatientRepository $patientRepository): Response
    {
        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findAll(),
        ]);
    }
    #[Route('/{id}/archive', name: 'patient_archive', methods: ['GET'])]
    public function archive( Patient $patient, DossierMedicalRepository $dossierMedicalRepository ): Response
    {



        // Récupérer les dossiers médicaux du patient
        $dossiers = $dossierMedicalRepository->findBy(['patient' => $patient]);


        // Rendre la vue avec les données du patient et ses dossiers médicaux
        return $this->render('patient/archive.html.twig', [
            'patient' => $patient,
            'dossiers' => $dossiers,
        ]);
    }
    #[Route('/new', name: 'app_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,  UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $patient = new Patient();
        $user = new User();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form['email']->getData();
            $nom = $form['nom']->getData();
            $prenoms = $form['prenoms']->getData();
            $user->setNom($nom);
            $user->setPrenoms($prenoms);
            $user->setEmail($email);
            $user->setRoles(['ROLE_PATIENT']);

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $patient->setUser($user);

            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patient_delete', methods: ['POST'])]
    public function delete(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
    }
}
