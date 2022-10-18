<?php
namespace App\Repository;

use App\Models\User;
use App\Models\Message;
Use Carbon\Carbon;
class ConversationsRepository {

	private $user;
	private $message;

	public function __construct(User $user, Message $message) {

		$this->user = $user;
		$this->message = $message;
    }
    public function getConversations( int $userid) {
      

       $conversations= $this->user->newQuery()
       ->select('name','id')
       ->where('id' ,'!=' , $userid)
       ->get();
      $unread= $this->unreadCount($userid);
       foreach($conversations as $conversation){
       	   if(isset($unread[$conversation->id])){
       	   	  $conversation->unread= $unread[$conversation->id];
       	   }

       	   else{
       	   	   $conversation->unread= 0;
       	   }
       }
       return $conversations;
    }

    public function createMessage(string $content, int $from, int $to){
      

    	return $this->message->newQuery()->create([
    	'content'	=> $content,
    	'from_id'	=> $from,
    	'to_id'	=> $to,
    	'created_at'	=> Carbon::now()
    	])
              ;
    }
	
	public function getMessageFor(int $from, int $to)  {

		return $this->message->newQuery()
		->whereRaw("((from_id = $from  AND to_id = $to) OR ( from_id = $to  AND to_id = $from))" )
		->orderBy('created_at','DESC') ;
	}

	public function unreadCount(int $userid){
		 
         return $this->message->newQuery()
         ->where('to_id', $userid)
         ->groupby('from_id')
         ->selectRaw('from_id, COUNT(id) as count')
         ->whereRaw('read_at IS NULL')
         ->get()
         ->pluck('count','from_id');
	}

	public function readAll(int $from, int $to){

		return $this->message->newQuery()->where('from_id', $from)->where('to_id', $to)->update(['read_at'=> Carbon::now()]);
	}
}

