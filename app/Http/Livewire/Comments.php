<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Comment;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
class Comments extends Component
{
    use WithPagination;
    // public $comments = [
    //     [
    //         'body'=>'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt doloremque pariatur nesciunt aliquam vel, quibusdam nulla eos suscipit mollitia commodi voluptate perspiciatis nihil deserunt ratione ipsam? Quidem illo veritatis harum!',
    //         'created_at'=>'3 min ago',
    //         'creator'=>'PhoeThar'
    //     ],
    // ];
    //public $comments ;
    public $newComment;
    public $image;
    public $ticketId;
    protected $listeners = [
        'fileupload' => 'handleFileUpload',
        'ticketSelected' => 'ticketSelected',
    ];
    public function handleFileUpload($imageData)
    {
        //dd($imageData);
        $this->image = $imageData;
    }
    public function ticketSelected($ticketId)
    {
        $this->ticketId = $ticketId;
    }
    public function mount()
    {
        /*
        -$this->comments = $initialcomment;
        -props passing
        -ifthe view render have the same name as props it can give the error
        -web mar view render data htae p . blade ka nay "$var" so yin tot pros ka data phit twar par tal
        -blade pros mar : htae chin ka render and passing ko solo par tal
        <!-- <livewire:comments :initialcomment="comment"/> $--> */
        
        // $initialcomment = Comment::latest()->get();
        // $this->comments = $initialcomment;
    }
    public function updated($field)
    {
        $this->validateOnly($field,['newComment'=>'required|max:255']);

    }
    public function addComment()
    {
        /*
        $this->comments[] =
             [
             'body'=>$this->newComment,
             'created_at'=>Carbon::now()->diffForHumans(),
             'creator'=>'Nigma.gh'
             ]; set data and add data 
        if($this->newComment == '')
        {
            return;
        }
        */
        $this->validate(['newComment'=>'required|max:255']);
        $image          = $this->storeImage();
        $createdComment=Comment::create(['body'=>$this->newComment,'user_id'=>1,
            'image' => $image,
            'support_ticket_id'=>$this->ticketId,
        ]);
        /*
        array_unshift($this->comments,[
            'body'=>$this->newComment,
            'created_at'=>Carbon::now()->diffForHumans(),
            'creator'=>'Nigma.gh'
        ]);
        
    
        */
        //$this->comments->prepend($createdComment);//prepend push //noeffect on db ID
        $this->newComment ="";
        $this->image      = '';
        session()->flash('message','Comment Added Successfully');
    }
    public function storeImage()
    {
        if(!$this->image)
        {
            return null;
        }
        $img   = ImageManagerStatic::make($this->image)->encode('jpg');
        $name  = Str::random() . '.jpg';
        Storage::disk('public')->put($name, $img);
        return $name;
    }
    
    public function remove($commentId)
    {
        $comment = Comment::find($commentId);
        //$this->comments = $this->comments->except($commentId);
        $comment->delete();
        session()->flash('message','Comment Deleted Successfully');
    }
    public function render()
    {
        $comments = Comment::where('support_ticket_id',$this->ticketId)->latest()->paginate(2);
        return view('livewire.comments',[
            'comments'=>$comments
        ]);
    }
}
