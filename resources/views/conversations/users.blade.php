<div class="col-md-3">
    		<div class="list-group">
       @foreach($users as $user)
          <a class="list-group-item" href="{{route('conversations.show', $user->id) }}">
          	{{$user->name}} 	
          	@if(isset($unread[$user->id]))
          	<span class="position-absolute  badge rounded-pill bg-danger"> {{$unread[$user->id]}}
    
    <span class="visually-hidden">unread messages</span>
  </span>
       	   	  
       	   
            @endif
          	
          	</a> 
          @endforeach
    
     </div>
     </div>