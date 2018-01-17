<?php

namespace App\Http\Controllers;

use App\Data\Models\Acao as ModelAcao;
use App\Data\Models\Juiz as ModelJuiz;
use App\Data\Models\Meio as ModelMeio;
use App\Data\Models\Processo;
use App\Data\Models\Tribunal as ModelTribunal;
use App\Data\Models\User as ModelUser;
use App\Data\Repositories\Processos as ProcessosRepository;
use App\Http\Requests\Processo as ProcessoRequest;
use App\Data\Models\Processo as ProcessoModel;

use Illuminate\Support\Facades\Input;

class Processos extends Controller {
    public function create() {
        $juizes = ModelJuiz::pluck('nome', 'id');
        $juizes = $juizes->sort();

        //dd($tiposjuizes);

        $tribunais = ModelTribunal::pluck('nome', 'id');
        $tribunais = $tribunais->sort();
        //dd($items);

        $usuarios = ModelUser::pluck('name', 'id');
        $usuarios = $usuarios->sort();

        $meios = ModelMeio::pluck('nome', 'id');
        $meios = $meios->sort();

        $acoes = ModelAcao::pluck('nome', 'id');
        $acoes = $acoes->sort();

        return view('processos.create', compact('juizes', 'tribunais', 'usuarios', 'meios', 'acoes'));
    }

    public function store(ProcessoRequest $request, ProcessosRepository $repository) {
        $repository->createFromRequest($request);

        return $this->create();
    }

    public function detail(ProcessoRequest $request)
    {
        $processo = Processo::find($request->id);
        return view('processos.detail',compact('processo'));
    }
}
