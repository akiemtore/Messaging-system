@extends('layouts.app')
 @section('content')
    <div class="container">
       <div class="row">
    	@include('conversations.users', ['users' => $users , 'unread' => $unread])
         
           <div class="col-md-9">
           	 <div class="card">
           	 	<div class="card-header">{{$user->name}} </div>
         	     <div class="card-body">
         	     	@if($messages->hasMorePages())
         	     	  <div class="text-center">
         	     	  	<a href="{{$messages->nextPageUrl()}}" class="btn btn-light">Voir les messages precedents</a>
         	     	  </div>
         	     	@endif
         	     	@foreach(array_reverse($messages->items()) as $message)
         	     	
         	     	  <div class="row">
                     @if((new DateTime($message->created_at))->format('d-m-Y') !== $day)
                             <div class="text-center"> {{$day=(new DateTime($message->created_at))->format('d-m-Y')}}</div>
                             @endif
         	     	  
                        <div class="col-md-10 {{ $message->from->id !== $user->id ? 'offset-md-8 text-right ':'' }}">
                        	<p>
                             
                        		<strong > {{ $message->from->id !== $user->id ? 'moi' :  
                        			$message->from->name}}   </strong > </br>
                              
                        			{{ nl2br($message->content)}} </br>
                              {{(new DateTime($message->created_at))->format('H:i')}}
                        	</p>
                        </div>
                        
                     </div>
                      @endforeach
                      @if($messages->previousPageUrl())
         	     	  <div class="text-center">
         	     	  	<a href="{{$messages->previousPageUrl()}}" class="btn btn-light">Voir les messages plus recents</a>
         	     	  </div>
         	     	@endif
         	     	<form action="" method="post">
                  
                    
         	     	   <div class="form-group">
         	     	   	  {{ csrf_field() }}
                          <textarea name="content"class="form-control" placeholder="Ecrivez votre message"></textarea>
         	     	   	  
          	          </div>
                    
          	         <div class="card-footer"> <button class="btn btn-primary" type="submit">Envoyer</button>  </div>
          	          </form>
         </div>
    	
     </div>
      </div>
     </div>
@endsection