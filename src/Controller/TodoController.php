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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\TodoRepository;

class TodoController extends AbstractController
{
    private $repository;
    public function __construct(TodoRepository $repository){
        $this->repository = $repository;
    }
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
        $form = $this->createFormBuilder($todo)->add('title', TextType::class, ['attr' => ['class'=>'form-control'],'label'=>'Naziv zadatka'])->add('description',TextareaType::class, ['attr' => ['class'=>'form-control'],'label'=>'Opis zadatka','required'=> false])->add('Duedate',DateType::class,['attr'=>['class'=>'form-control'],'label'=>'Rok izvršenja'])->add('Difficulty', ChoiceType::class,['choices'=>['1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5],'attr' => ['class'=>'form-control'],'label'=>'Težina'])->add('save', SubmitType::class, ['label'=>'Spremi','attr'=>['class'=>'btn btn-secondary mt-2']])->getForm();
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
    /**
     * @Route("/edit/{id}", name="edit", methods={"GET","POST"})
     */
    public function editTodo(Request $request,$id)
    {
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
        $form = $this->createFormBuilder($todo)->add('title', TextType::class, ['attr' => ['class'=>'form-control'],'label'=>'Naziv zadatka'])->add('description',TextareaType::class, ['attr' => ['class'=>'form-control'],'label'=>'Opis zadatka','required'=> false])->add('Duedate',DateType::class,['attr'=>['class'=>'form-control'],'label'=>'Rok izvršenja'])->add('Difficulty', ChoiceType::class,['choices'=>['1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5],'attr' => ['class'=>'form-control'],'label'=>'Težina'])->add('save', SubmitType::class, ['label'=>'Spremi','attr'=>['class'=>'btn btn-secondary mt-2']])->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $todo = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();
            return $this->redirect('/');
     
        
    }   return $this->render('editTodo.html.twig',['todo'=>$todo,'form'=>$form->createView()]) ;}

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function deleteTodo($id){
       
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($todo);
        $em->flush();
        return $this->redirect('/');
      
    }
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
