<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Models\Llibre;
use App\Models\Autor;

use DateTime;

class LlibreController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function list() 
    { 
      $llibres = Llibre::all();

      return view('llibre.list', ['llibres' => $llibres]);
    }

    function new(Request $request) 
    { 
      if ($request->isMethod('post')) {    
        $dataAvui = new DateTime();
        $dataFormat = $dataAvui->format('d-m-Y');

        // recollim els camps del formulari en un objecte llibre
        $validated = $request->validate([
          'titol' => 'required|min:2|max:20',
          'dataP' => 'before:' . $dataFormat,
          'vendes' => 'required'
        ],[
          'required' => 'Camp Obligatori',
          'max' => 'Número de caracters màxim :max',
          'min' => 'Número de cracters mínim :min',
          'before' => 'La data ha de ser anterior a: ' . $dataFormat
        ]);

        $llibre = new Llibre;
        $llibre->titol = $request->titol;
        $llibre->dataP = $request->dataP;
        $llibre->vendes = $request->vendes;
        $llibre->autor_id = $request->autor_id;
        $llibre->save();

        
        return redirect()->route('llibre_list')->with('status', 'Nou llibre '.$llibre->titol.' creat!')->cookie('autor', $llibre->autor_id, 60);

      }
      // si no venim de fer submit al formulari, hem de mostrar el formulari

      $autors = Autor::all();
      $autor_c = $request->cookie('autor');

      return view('llibre.new', ['autors' => $autors, 'autor_c' => $autor_c]);
    }

    function edit(Request $request, $id) 
    { 
      if ($request->isMethod('post')) {    
        $dataAvui = new DateTime();
        $dataFormat = $dataAvui->format('d-m-Y');
        // recollim els camps del formulari en un objecte llibre
        $validated = $request->validate([
          'titol' => 'required|min:2|max:20',
          'dataP' => 'before:' . $dataFormat,
          'vendes' => 'required'
        ],[
          'required' => 'Camp Obligatori',
          'max' => 'Número de caracters màxim :max',
          'min' => 'Número de cracters mínim :min',
          'before' => 'La data ha de ser anterior a: ' . $dataFormat
        ]);
        
        $llibre = Llibre::find($id);
        $llibre->titol = $request->titol;
        $llibre->dataP = $request->dataP;
        $llibre->vendes = $request->vendes;
        $llibre->autor_id = $request->autor_id;
        $llibre->save();

        return redirect()->route('llibre_list')->with('status', 'Llibre '.$llibre->titol.' desat!');
      }
      // si no venim de fer submit al formulari, hem de mostrar el formulari
      
      $llibre = Llibre::find($id);
      $autors = Autor::all();

      return view('llibre.edit', ['llibre' => $llibre, 'autors' => $autors]);
    }

    function delete($id) 
    { 
      $llibre = Llibre::find($id);
      $llibre->delete();

      return redirect()->route('llibre_list')->with('status', 'Llibre '.$llibre->titol.' eliminat!');
    }

    function borrarCookie(){
      return redirect()->route('llibre_list')->with('status', 'Cookie borrada ')->withoutCookie('autor');
    }
}
