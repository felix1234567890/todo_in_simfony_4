<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Todo;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TodoController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home () 
    {
        $todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();
     return $this->render('todoList.html.twig', ['todos'=>$todos]);
    }

     /**
     * @Route("/addTodo", methods={"GET","POST"})
     */
    public function addTodo(Request $request){
        $todo = new Todo();
        $form = $this->createFormBuilder($todo)->add('title', TextType::class, ['attr' => ['class'=>'form-control']])->add('description',TextareaType::class, ['attr' => ['class'=>'form-control'],'required'=> false])->add('save', SubmitType::class, ['label'=>'Spremi','attr'=>['class'=>'btn btn-secondary mt-2']])->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $todo = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();
            return $this->redirect('/');
        }
        return $this->render('todoForm.html.twig',['form'=>$form->createView()]);

       
    }

    /**
     * @Route("/todo/{id}")
     */
    public function showTodo($id){
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
        return $this->render('singleTodo.html.twig', compact("todo"));
    }
   
    // /**
    //  * @Route("/addTodo")
    //  */
    // public function add(){
    //     $em = $this->getDoctrine()->getManager();
    //     $todo = new Todo();
    //     $todo->setTitle('Ovo je prvi zadatak');
    //     $todo->setDescription('Ovdje bi trebao napisati detaljniji opis prvog zadatka, ali nemam ideju');
    //     $em->persist($todo);
    //     $em->flush();
    //     return new Response('Spremljeno');
    // }
}