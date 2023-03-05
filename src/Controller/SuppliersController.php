<?php

namespace App\Controller;

use App\Entity\Suppliers;
use App\Form\SuppliersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuppliersController extends AbstractController
{


    private $em;


    public function __construct(EntityManagerInterface $em){


        $this->em = $em;



    }

    //LISTA DE PROVEEDORES
    #[Route('/', name: 'app_suppliers')]
    public function index(Request $request): Response
    {

        $suppliers = $this->em->getRepository(Suppliers::class)->findAllSuppliers();





       
        return $this->render('suppliers/index.html.twig', [
            'suppliers' => $suppliers
        ]);
    }
//CREACIÓN DE PROVEEDORES

    #[Route('/new', name: 'new_suppliers')]
    public function new(Request $request) {

        $supplier = new Suppliers();
       




        $form = $this->createForm(SuppliersType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($supplier);
            $this->em->flush();
            return $this->redirectToRoute("app_suppliers");


        }

        $supplier = new Suppliers();

        $form = $this->createForm(SuppliersType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($supplier);
            $this->em->flush();
            return $this->redirectToRoute("app_suppliers");


        }


       
    

       
        return $this->render('suppliers/create.html.twig', [
            'form' => $form->createView()
        ]);
      
    }

    // EDIICIÓN DE UN PROVEEDOR

    #[Route('/update/{id}', name: 'update_suppliers')]
    public function update(Request $request, $id) {

        $suppliers = $this->em->getRepository(Suppliers::class)->find($id); 
      

    $form = $this->createForm(SuppliersType::class, $suppliers);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()){
        $suppliers->setDateUpdate(new \DateTime());
        $this->em->persist($suppliers);
        $this->em->flush();
        return $this->redirectToRoute("app_suppliers");


    }


    return $this->render('suppliers/update.html.twig', [
        'form' => $form->createView()
    ]);


    }


    // ELIMINACION DE PROVEEDORES
    #[Route('/remove/{id}', name: 'remove_suppliers')]
    public function remove(Request $request, $id) {

        $suppliers = $this->em->getRepository(Suppliers::class)->find($id); 
        $this->em->remove($suppliers);
        $this->em->flush();
        return $this->redirectToRoute("app_suppliers");


    }

}
