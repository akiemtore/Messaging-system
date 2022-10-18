<?php

namespace App\Http\Controllers;

use App\Repository\conversationsRepository;
use App\Http\Requests\storeMessageRequest;
use App\Models\User;
use App\Notifications\MessageReceived;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthManager;
use DateTime;

class conversationsController extends Controller
{

	private $r;
	private $auth;

	public function __construct(ConversationsRepository $conversationsRepository, AuthManager $auth){
		$this->r = $conversationsRepository;
		$this->auth = $auth;
	}
    public function index(){
           $unread=$this->r->unreadCount($this->auth->user()->id);

      echo "<pre>";
      print_r($unread);
      echo "</pre>";
     
      return view('/conversations/index' , ['users' => $this->r->getConversations($this->auth->user()->id ),
        'unread' => $this->r->unreadCount($this->auth->user()->id)  ]);
    }

    public function show( User $user){
    	$me=$this->auth->user();
      $unread=$this->r->unreadCount($this->auth->user()->id) ;

    
      if(isset($unread[$user->id])){
        $this->r->readAll($user->id, $me->id);
         unset($unread[$user->id]);
       } 
       $day=null;
        return view('/conversations/show' , [

               'day'=>$day,
               'users' => $this->r->getConversations($this->auth->user()->id ) ,
              
                'user' =>  $user ,
                 'unread' => $unread,
                'messages' => $this->r->getMessageFor($this->auth->user()->id , $user->id )->paginate(8)
            ] );
      
    }

    public function store(User $user, storeMessageRequest $requete ){

    	 $this->r->createMessage(
           
           $requete->get('content'),
           $this->auth->user()->id, 
           $user->id
    		) ;
     // $user->notify(new MessageReceived($message));
    	return redirect(route('conversations.show' , [ 'user' =>  $user ] ) );

    }
}
