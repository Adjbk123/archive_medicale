<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\DossierMedical;
use App\Entity\Medecin;
use App\Entity\Patient;
use App\Repository\DossierMedicalRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(EntityManagerInterface $entityManager, PatientRepository $patientRepository, DossierMedicalRepository $dossierMedicalRepository): Response
    {
        $patientsCount = $patientRepository->count([]);
        $medecinsCount = $entityManager->getRepository(Medecin::class)->count([]);
        $dossiersCount = $entityManager->getRepository(DossierMedical::class)->count([]);
        $documentsCount = $entityManager->getRepository(Document::class)->count([]);
        $latestDossiers = $entityManager->getRepository(DossierMedical::class)->findBy([], ['dateCreation' => 'DESC'], 5);

        $user = $this->getUser();
        $patient  = $patientRepository->findOneBy(['user'=>$user]);

        $dossierPatientCount =count($dossierMedicalRepository->findBy(['patient'=>$patient])) ;


        return $this->render('admin/index.html.twig', [
            'patientsCount' => $patientsCount,
            'medecinsCount' => $medecinsCount,
            'dossiersCount' => $dossiersCount,
            'documentsCount' => $documentsCount,
            'latestDossiers' => $latestDossiers,
            'dossierPatientCount'=> $dossierPatientCount

        ]);
    }
}
