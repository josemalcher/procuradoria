@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-8 col-md-10">
                    <h4>
                        <a href="{{ route('andamentos.index') }}">Andamentos</a>

                        @if(is_null($andamento->id))
                            > NOVO
                        @endif
                    </h4>
                </div>

                <div class="col-xs-4 col-md-2">
                    @include('partials.save-button')
                    @include('partials.edit-button', ['model' => $andamento])
                </div>
            </div>
        </div>

        <div class="panel-body">
            @include('partials.alerts')

            {{--{{dd(isset($id))}}--}}

            <form name="formulario" id="formulario"
                  @if(isset($id))
                        action="{{ route('andamentos.store',['redirect'=>$id]) }}"
                  @else
                        action="{{ route('andamentos.store') }}"
                  @endif
                  method="POST">

                {{ csrf_field() }}
                <input type="hidden" name="id" id="id" value="{{$andamento->id}}">
                {{--{{dump($andamento->id)}}--}}
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="nome">Processo</label>

                        @if(!isset($id))
                            <select name="processo_id" class="form-control select2" id="processo_id" aria-describedby="numero_judicialHelp" placeholder="Processo" @include('partials.disabled')>
                                @if(!is_null(old('processo_id')))
                                    <option value="">Selecione...</option>
                                @else
                                    <option value="">Selecione...</option>
                                @endif
                                @foreach ($processos as $key => $processo)
                                    @if((!is_null($andamento->processo) && $andamento->processo->id == $key)
                                        || (!is_null(old('processo_id')) && old('processo_id')==$key))
                                        <option selected="selected"  value="{{ $key }}" >{{ $processo }}</option>
                                    @else
                                        <option value="{{ $key }}" >{{ $processo }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="processo_id" id="processo_id" value="{{$id}}">
                            <select name="processo_id" class="form-control select2" id="processo_id" aria-describedby="numero_judicialHelp" placeholder="Processo" disabled="disabled">
                                @foreach ($processos as $key => $processo)
                                    @if($id == $key || (!is_null(old('id')) && old('id')==$key))
                                        <option value="{{ $key }}" selected>{{ $processo }}</option>

                                    @endif
                                @endforeach

                            </select>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="tipo_andamento_id">Tipo de andamento</label>
                        <select name="tipo_andamento_id" class="form-control select2" id="tipo_andamento_id" aria-describedby="numero_judicialHelp" placeholder="Processo"  @include('partials.disabled')>
                            <option value="" >Selecione...</option>

                            @foreach ($tipoAndamentos as $key => $tipoAndamento)
                                @if(!is_null($andamento->tipoAndamento) && $andamento->tipoAndamento->id == $key ||
                                    (!is_null(old('tipo_andamento_id')) && old('tipo_andamento_id')== $key))
                                    <option selected="true" value="{{ $key }}" >{{ $tipoAndamento }}</option>
                                @else
                                    <option value="{{ $key }}" >{{ $tipoAndamento }}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="Processo">Tipo de entrada</label>
                        @if(is_null($andamento->id))
                            <p><label name="tipo_entrada">Manual</label></p>
                            <input type="hidden" name="tipo_entrada_id" id="tipo_entrada_id" value="1" />
                        @else
                            <p><label name="tipo_entrada">{{$andamento->tipoEntrada->nome}}</label></p>
                            <input type="hidden" name="tipo_entrada_id" id="tipo_entrada_id" value="{{$andamento->tipoEntrada->id}}" />
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="Processo">Tipo prazo</label>
                        <select name="tipo_prazo_id" class="form-control select2" id="tipo_prazo_id" aria-describedby="numero_judicialHelp" placeholder="tipo_prazo_id" @include('partials.disabled')>
                            <option selected="true" value="">Selecione</option>
                            @foreach ($tipoPrazos as $key => $prazo)
                                @if(!is_null($andamento->tipoPrazo) && $andamento->tipoPrazo->id == $key ||
                                    (!is_null(old('tipo_prazo_id')) && old('tipo_prazo_id')== $key)))
                                    <option selected="true" value="{{ $key }}" >{{ $prazo }}</option>
                                @else
                                    <option value="{{ $key }}" >{{ $prazo }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="data_prazo">Data do Andamento</label>
                        @if(!is_null(old('data_andamento')))
                            <input  value="{{old('data_andamento')}}"  type="date"  name="data_andamento" class="form-control" id="data_andamento" placeholder="Data Prazo" @include('partials.disabled') >
                        @else
                            <input  value="{{$andamento->data_andamento}}"  type="date"  name="data_andamento" class="form-control" id="data_andamento" placeholder="Data Prazo" @include('partials.disabled') >
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="data_prazo">Data prazo</label>
                        @if(!is_null(old('data_prazo')))
                            <input  value="{{old('data_prazo')}}"  type="date"  name="data_prazo" class="form-control" id="data_prazo" placeholder="Data Prazo" @include('partials.disabled') >
                        @else
                            <input  value="{{$andamento->data_prazo}}"  type="date"  name="data_prazo" class="form-control" id="data_prazo" placeholder="Data Prazo" @include('partials.disabled') >
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="data_entrega">Data entrega</label>
                        @if(!is_null(old('data_entrega')))
                            <input  value="{{old('data_entrega')}}" type="date" name="data_entrega" class="form-control" id="data_entrega" placeholder="Data Entrega" @include('partials.disabled')>
                        @else
                            <input  value="{{$andamento->data_entrega}}" type="date" name="data_entrega" class="form-control" id="data_entrega" placeholder="Data Entrega" @include('partials.disabled')>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="observacoes">Observação</label>

                        @if(!is_null(old('observacoes')))

                            <textarea   name="observacoes" class="form-control" id="observacoes" placeholder="" @include('partials.disabled')>{{old('observacoes')}}</textarea>

                        @else

                            <textarea   name="observacoes" class="form-control" id="observacoes" placeholder="" @include('partials.disabled')>{{$andamento->observacoes}}</textarea>

                        @endif

                    </div>
                </div>

                    @include('partials.save-button')
                </form>
        </div>
    </div>
@endsection
