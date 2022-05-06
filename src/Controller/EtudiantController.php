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


    #[Route('/add', name: 'etudiant.add')]
    public function add(Request $req): Response
    {  $e=new Etudiant();
        $form=$this->createForm(EtudiantType::class,$e);
        $form->handleRequest($req);
        if ($form->isSubmitted()){
            $this->manager->persist($e);
            $this->manager->flush($e);
            $this->addflash('succes','Etudiant ajouté!');
            return $this->redirectToRoute('etudiant.list');
        }
        return $this->render('etudiant/form.html.twig',['form'=>$form->createView()]);
    }


    #[Route('/update/{id}/{nom}/{prenom}/{section}', name: 'etudiant.update')]
    public function update(Etudiant $e=null,$nom,$prenom,$section): Response
    {
        if ($e){
            $e->setNom($nom);
            $e->setPrenom($prenom);
            $e->setSection($section);
            $this->manager->persist($e);
            $this->manager->flush($e);
            $this->addFlash('success','Etudiant mis a jour!');
        }else{
            $this->addFlash('error','Cet etudiant n existe pas!');
        }
        return $this->redirectToRoute('etudiant.list');
    }

    #[Route('/update/{id}', name: 'etudiant.remove')]
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
