<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Entity\Client;
use App\Entity\Contract;
use App\Form\ContractType;
use App\Repository\ContractRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{agency_slug}/contract")
 */
class ContractController extends AbstractController
{

    /**
     * @Route("/", name="contract_index", methods={"GET"})
     */
    public function index(ContractRepository $contractRepository): Response
    {
        
        $contracts = $contractRepository->createQueryBuilder('co')
                ->addSelect('cl')
                ->leftJoin('co.client', 'cl')
                ->getQuery()
                ->getResult();
        return $this->render('contract/index.html.twig', [
                    'contracts' => $contracts,
        ]);
    }

    /**
     * @Route("/new", name="contract_new", methods={"GET","POST"})
     */
    public function new(Request $request, Agency $agency): Response
    {
        $contract = new Contract($agency);
        
        if ($request->get('client_id')) {
            $client = $this->getDoctrine()->getRepository(Client::class)->find($request->get('client_id'));
            $contract->setClient($client);
        }
        
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contract);
            $entityManager->flush();

            return $this->redirectToRoute('contract_index');
        }

        return $this->render('contract/new.html.twig', [
                    'contract' => $contract,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contract_show", methods={"GET"})
     */
    public function show(Contract $contract): Response
    {
        return $this->render('contract/show.html.twig', [
                    'contract' => $contract,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contract_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contract $contract): Response
    {
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contract_index', [
                        'id' => $contract->getId(),
            ]);
        }

        return $this->render('contract/edit.html.twig', [
                    'contract' => $contract,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contract_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contract $contract): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contract->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contract);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contract_index');
    }
}
