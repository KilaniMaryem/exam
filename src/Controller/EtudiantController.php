<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/etudiant')]
class EtudiantController extends AbstractController
{   private $manager;
    private $repo;
    public function __construct(ManagerRegistry $doctrine)
    {$this->manager=$doctrine->getManager();
        $this->repo=$doctrine->getRepository(Etudiant::class);
    }

    #[Route('/', name: 'etudiant.list')]
    public function index(): Response
    {  $etudiants=$this->repo->findAll();
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiants,
        ]);
    }


    #[Route('/add/{id?0}', name: 'etudiant.add')]
    public function add(Request $req, Etudiant $e=null): Response
    {  if (!$e){
        $e=new Etudiant();
    }
        $form=$this->createForm(EtudiantType::class,$e);
        $form->handleRequest($req);
        if ($form->isSubmitted()){
            $this->manager->persist($e);
            $this->manager->flush($e);

            $this->addflash('success','Etudiant ajouté!');
            return $this->redirectToRoute('etudiant.list');
        }
        return $this->render('etudiant/form.html.twig',['form'=>$form->createView()]);
    }





    #[Route('/remove/{id}', name: 'etudiant.remove')]
    public function remove(Etudiant $e=null): Response
    {
        if ($e){
           $this->manager->remove($e);
            $this->manager->flush($e);
            $this->addFlash('success','Cet etudiant est supprime!');
        }else{
            $this->addFlash('error','Cet etudiant n existe pas!');
        }
        return $this->redirectToRoute('etudiant.list');
    }
}
