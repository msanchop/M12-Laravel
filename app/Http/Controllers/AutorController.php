<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Autor;

class AutorController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function list() 
    { 
      $autors = Autor::all();

      return view('autor.list', ['autors' => $autors]);
    }

    function new(Request $request) 
    { 
      if ($request->isMethod('post')) {    
        // recollim els camps del formulari en un objecte autor
        $validated = $request->validate([
          'nom' => 'required|max:20',
          'cognoms' => 'required|max:30'
        ],[
          'required' => 'Camp Obligatori',
          'max' => 'Número de caracters màxim :max',
          'min' => 'Número de cracters mínim :min'
        ]);


        $autor = new Autor;
        $autor->nom = $request->nom;
        $autor->cognoms = $request->cognoms;
        if($request->file('imatge')){
          $file = $request->file('imatge');
          $filename = $autor->nom . "_" . $autor->cognoms . "." . $file->getClientOriginalExtension();
          $file->move(public_path(env('RUTA_IMATGES', false)), $filename);
          $autor->imatge = $filename;
        }
        $autor->save();

        return redirect()->route('autor_list')->with('status', 'Nou autor '.$autor->nomCognoms().' creat!');
      }
      // si no venim de fer submit al formulari, hem de mostrar el formulari

      return view('autor.new');
    }

    function edit(Request $request, $id) 
    { 
      if ($request->isMethod('post')) {    
        // recollim els camps del formulari en un objecte autor
        $validated = $request->validate([
          'nom' => 'required|max:20',
          'cognoms' => 'required|max:30'
        ],[
          'required' => 'Camp Obligatori',
          'max' => 'Número de caracters màxim :max',
          'min' => 'Número de cracters mínim :min'
        ]);
        
        $autor = Autor::find($id);
        $autor->nom = $request->nom;
        $autor->cognoms = $request->cognoms;

        if(isset($request->borrarImatge)){
          //Storage::delete('uploads/imatges/' . $autor->imatge);
          $autor->imatge = null;
        }

        $autor->save();

        return redirect()->route('autor_list')->with('status', 'Autor '.$autor->nomCognoms().' desat!');
      }
      // si no venim de fer submit al formulari, hem de mostrar el formulari
      
      $autor = Autor::find($id);

      return view('autor.edit', ['autor' => $autor]);
    }

    function delete($id) 
    { 
      $autor = Autor::find($id);
      $autor->delete();

      return redirect()->route('autor_list')->with('status', 'Autor '.$autor->nomCognoms().' eliminat!');
    }
}
