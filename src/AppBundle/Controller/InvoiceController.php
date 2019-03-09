<?php
/**
 * Created by PhpStorm.
 * User: marcom
 * Date: 04/03/19
 * Time: 15.04
 */

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Invoice;
use AppBundle\Entity\InvoiceData;



class InvoiceController extends Controller
{

    /**
     * @Route("/home",name="home")
     */
    public function indexAction(){

        //render template with template engine TWIG
        return $this->render('home/index.html.twig');

    }

    /**
     * @Route("/invoice/create",name="invoices_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request){


        $content = $request->getContent();
        if(!empty($content)){

            parse_str($content, $parameters);

            //Validation
            foreach ($parameters as $param){

                if(empty($param)){
                    return $this->redirectToRoute("invoices_create");
                }

            }

            //Manager Doctrine Database
            $entityManager = $this->getDoctrine()->getManager();

            $invoice = new Invoice();

            $invoice->setNumber($parameters["number_invoice"]);
            $invoice->setCreationDate(new \DateTime($parameters["date_creation_invoice"]));
            $invoice->setIdClient($parameters["id_client"]);

            // tells Doctrine you want to (eventually) save the Invoice
            $entityManager->persist($invoice);

            //check data invoice
            if(!empty($rows =  $request->request->get("rows"))){

                $this->saveInvoiceData($request,$rows,$invoice);

            }

            $entityManager->flush();

            return new Response('Saved new invoice with id '.$invoice->getId().'<a style="margin-left: 20px" href="/invoice/create">Back to create</a>');

        }else{

            //render template with template engine TWIG
            return $this->render('home/create.html.twig');
        }


    }

    /**
     * @Route("/invoice/list/{page}",name="invoices_show",requirements={"page"="\d+"})
     */
    public function showAction($page = 1){

        $invoices = $this->getDoctrine()->getRepository(Invoice::class)->findAll();

        //\Doctrine\Common\Util\Debug::dump($invoices);

        //render template with template engine TWIG
        return $this->render('home/list.html.twig',['invoices'=>$invoices]);

    }

    /**
     * @param $request
     * @param $rows
     * @param $invoice Invoice
     * @return bool
     */
    private function saveInvoiceData($request, $rows, $invoice){

        $description = $request->request->get("description");
        $quantity = $request->request->get("quantity");
        $amount = $request->request->get("amount");
        $tax = $request->request->get("tax");
        $total = $request->request->get("total");

        //Manager Doctrine Database
        $entityManager = $this->getDoctrine()->getManager();

        foreach (array_keys($rows) as $key){

            $invoiceData = new InvoiceData();

            $invoiceData->setDescription($description[$key]);
            $invoiceData->setAmount($amount[$key]);
            $invoiceData->setQty($quantity[$key]);
            $invoiceData->setTax($tax[$key]);
            $invoiceData->setTotal($total[$key]);

            //relationship
            $invoiceData->setInvoice($invoice);

            $entityManager->persist($invoiceData);

        }

        $entityManager->flush();

        return true;

    }

}