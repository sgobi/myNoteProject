<?php

namespace App\Http\Controllers;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{

    public function _construct(){


    }


    public function handle($request, Closure $next) {
        // Middleware should be defined here
        $this->middleware('auth');
        return $next($request);
    }
    
    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::latest()->paginate(5); // Assuming you're fetching all notes
     
  // Calculate the index for pagination
  $i = (request()->input('page', 1) - 1) * 5;

          return view('notes.index',compact('notes')) ->with('i',$i);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // Validate the incoming request data
    $validatedData = $request->validate([
        'title' => 'required|string|max:255', // Adjust validation rules as necessary
        'content' => 'required|string', // Assuming you have a 'content' field
    ]);


$request->merge(['user_id'=>Auth::id()]);

    $validatedData['user_id'] = Auth::id(); // Replace 1 with the appropriate user ID if dynamic
    // Create a new note using the validated data
    Note::create($validatedData);

        return redirect()->route('notes.index')
        ->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {

        if($note->user_id!==Auth::id()){

            return redirect()->route('notes.index')->with('error','You cant Eligible to Update');
        }

              // Validate the incoming request data
    $validatedData = $request->validate([
        'title' => 'required|string|max:255', // Adjust validation rules as necessary
        'content' => 'required|string', // Assuming you have a 'content' field
    ]);
    $validatedData['user_id'] = 1; // Replace 1 with the appropriate user ID if dynamic
    $note->update($validatedData);

    return redirect()->route('notes.index')
    ->with('success', 'Note UPdated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if($note->user_id!==Auth::id()){

            return redirect()->route('notes.index')->with('error','You cant Eligible to Delete');
        }
       

        try {
            $note->delete();
            return redirect()->route('notes.index')
                ->with('success', 'Note Deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('notes.index')
                ->with('error', 'There was a problem deleting the note.');
        }
    }
}
