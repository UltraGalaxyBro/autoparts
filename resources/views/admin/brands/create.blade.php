@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Marcas</h4>
        <p>As marcas possuem o propósito organizacional fornecendo a origem de determinado código de fabricante que houver
            em um produto.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list brands')
            <a href="{{ route('brands.index') }}" class="btn btn-sm btn-secondary">Listar marcas</a>
        @endcan
    </div>
    <div class="mb-5">
        <form action="{{ route('brands.store') }}" method="POST">
            @csrf
            @method('post')

            <h4 class="fw-bold text-center mb-3">Cadastrando marca</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="name" name="name"
                            placeholder="Sem abreviações" value="{{ old('name') }}">
                        <label for="name">Nome</label>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-lg btn-success rounded-3" title="Cadastrar marca" type="submit"
                     onclick="this.innerText = 'Cadastrando...'">Cadastrar</button>
            </div>
        </form>
    </div>
@endsection
