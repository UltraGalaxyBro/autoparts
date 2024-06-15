@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Níveis para clientes</h4>
        <p>
            Muita atenção ao arquitetar os níveis para seus clientes, pois haverão os descontos sobre as compras dos
            clientes de acordo com o que for definido aqui. Lembre-se que, caso um produto esteja em promoção, os descontos
            irão somar, por isso defina os valores de desconto com cuidado.
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list levels')
            <a href="{{ route('levels.index') }}" class="btn btn-sm btn-primary">Listar níveis</a>
        @endcan
    </div>
    <div class="mb-5">
        <form action="{{ route('levels.update', ['id' => $level->id]) }}" method="POST">
            @csrf
            @method('put')

            <h4 class="fw-bold text-center mb-3">Editando nível para clientes</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="name" name="name"
                            placeholder="Sem abreviações" value="{{ old('name', $level->name) }}">
                        <label for="name">Nome/Apelido (visível aos clientes)</label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-floating mb-3">
                        <textarea class="form-control rounded-3" placeholder="" id="description" name="description">{{ old('description', $level->description) }}</textarea>
                        <label for="description">Descrição explicativa (visível aos clientes)</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center mb-2 mt-3">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="number" step="0.01" class="form-control rounded-3" id="discount" name="discount"
                            placeholder="Sem abreviações" value="{{ old('discount', $level->discount) }}">
                        <label for="discount">Desconto (%)</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <h5 class="fw-bold text-center">Exemplo visual da aplicação do nível</h5>
                        <div class="card" style="width: 15rem; position: relative;">
                            <span class="ms-2 mt-1 badge fw-bolder text-bg-primary position-absolute">DESCONTO DO NÍVEL
                                <i class="fa-solid fa-user-tag"></i>
                            </span>
                            <img src="{{ asset('img/products/default-image.png') }}" class="card-img-top rounded"
                                alt="Imagem do produto">
                            <div class="row">
                                <div class="card-title text-center">
                                    <span class="badge text-bg-secondary mt-3 text-decoration-line-through"
                                        style="font-size: 13px;">R$ 1.000,00</span>
                                    <span class="badge text-bg-success mt-3" id="nivel-aplicado" style="font-size: 15px;">R$
                                        1.000,00</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title overflow-tooltip" title="FILTRO DE AR PRIMÁRIO"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    PRODUTO EXEMPLO</h6>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    MARCA:<br><strong><em>Marca exemplo</em></strong></li>
                                <li class="list-group-item overflow-tooltip" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="ASR8976 0036958781"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    CÓDIGO(S):<br><strong>54545454515 XXXXXX</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-lg btn-success rounded-3" title="Editar nível para clientes" type="submit"
                     onclick="this.innerText = 'Editando...'">Editar</button>
            </div>
        </form>
    </div>
@endsection
