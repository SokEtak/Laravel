<?php

    namespace App\Http\Controllers;

    use App\Models\Ninjas;
    use Illuminate\Http\Request;
    use App\Models\Dojo;
    class NinjasController extends Controller
    {
        public function index(){

            $ninjas = Ninjas::with('dojo')->get();
        
            return view('ninjas.index', ['ninjas' => $ninjas]);
        }
        public function show($id){
            $ninja = Ninjas::with('dojo')->findOrFail($id);
            //dd($ninja);
            return view('ninjas.show', ['ninja' => $ninja]);
        }
        public function create(){
            $dojos = Dojo::all();
            return view('ninjas.create', ['dojos' => $dojos]); 
        }

        public function store(Request $request){
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'damage' => 'required|integer|min:0',
                'skill' => 'required|string|max:255',
                'dojo_id' => 'required|exists:dojos,id',
            ]);
        
            Ninjas::create($validatedData);
        
            return redirect()->route('ninjas.index')->with('success', 'Ninja created successfully.');
        }

    }
