<div>
    <h1 class="text-3xl">Comments</h1>

    @error('newComment') <span class="text-red-500 text-xs">{{$message}}</span> @enderror

    @if(session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
              <strong class="font-bold">Holy smokes!</strong>
              <span class="block sm:inline">{{session('message')}}</span>
              <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
              </span>
            </div>
        @endif
    <section>
        @if($image)
        <img src="{{$image}}" alt="" width="120px" height="120px">
        @endif
        <input type="file" id="image" wire:change="$emit('fileChoosen')">
    </section>
    <form class="my-4 flex" wire:submit.prevent="addComment">
        
        <input type="text" class="w-full rounded border shadow p-2 mr-2 my-2" placeholder="What's in your mind."
           wire:model.debounce.500ms="newComment"><br>
        <div class="py-2">
            <button type="submit" class="p-2 bg-blue-500 w-20 rounded shadow text-white">Add</button>
        </div>
    </form>
    @foreach($comments as $comment)
    <div class="rounded border shadow p-3 my-2">
        <div class="flex justify-between my-2">
            <div class="flex">
                <p class="font-bold text-lg">{{$comment['creator']['name']}}</p>
                <p class="mx-3 py-1 text-xs text-gray-500 font-semibold">
                {{$comment->created_at->diffForHumans()}}</p>
            </div>
            <i class="fas fa-times text-red-200 hover:text-red-600 cursor-pointer"
                wire:click="remove({{$comment->id}})"></i>
        </div>
        <p class="text-gray-800">{{$comment->body}}</p>
        @if($comment->image)
            <img src="{{$comment->imagePath}}" alt="{{$comment->imagePath}}" width="120px" height="120px">
        @endif
    </div>
    @endforeach
    {{$comments->links('pagination-links')}}
</div>
<script>
    window.Livewire.on('fileChoosen',()=>{
        let inputField = document.getElementById('image');
        let file = inputField.files[0];
        let reader = new FileReader();
        reader.onloadend = ()=>{
            window.Livewire.emit('fileupload',reader.result)
            //console.log(reader.result);
        }
        reader.readAsDataURL(file)
    })
</script>