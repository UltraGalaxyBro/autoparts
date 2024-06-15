@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Fornecedores</h4>
        <p>É importante registrar os fornecedores a título de organização na criação de um produto. Fornecedores estão
            vinculados a localização de um produto, visto que pode haver fornecedores em alguns locais, mas também não.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list suppliers')
            <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-secondary">Listar fornecedores</a>
        @endcan
    </div>
    <div class="mb-5">
        <form action="{{ route('suppliers.update', ['id' => $supplier->id]) }}" method="POST">
            @csrf
            @method('put')

            <h4 class="fw-bold text-center mb-3">Editando marca</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="name" name="name"
                            placeholder="Sem abreviações" value="{{ old('name', $supplier->name) }}">
                        <label for="name">Nome</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        @if (count($supplier->supplierContacts) > 0)
                            <select autocomplete="off" class="form-select" id="contacting" name="contacting"
                                aria-label="Informativo sobre cadastrar contatos">
                                <option value="Sim" {{ old('contacting') == 'Sim' ? 'selected' : null }}>Sim</option>
                                <option value="Não" {{ old('contacting') == 'Não' ? 'selected' : null }}>Não</option>
                            </select>
                            <label for="contacting">Informar contato(s)</label>
                        @else
                            <select autocomplete="off" class="form-select" id="contacting" name="contacting"
                                aria-label="Informativo sobre cadastrar contatos">
                                <option value="Não" {{ old('contacting') == 'Não' ? 'selected' : null }}>Não</option>
                                <option value="Sim" {{ old('contacting') == 'Sim' ? 'selected' : null }}>Sim</option>
                            </select>
                            <label for="contacting">Informar contato(s)</label>
                        @endif
                    </div>
                </div>
            </div>
            <div class="contacts-fields" style="display: none;" x-data="{
                contacts: [
                    @if (count(old('contacts', [])) > 0) @foreach (old('contacts', []) as $oldContact)
                            {
                                name: '{{ $oldContact['name'] ?? '' }}',
                                telephone: '{{ $oldContact['telephone'] ?? '' }}',
                                celphone: '{{ $oldContact['celphone'] ?? '' }}',
                                whatsapp: {{ isset($oldContact['whatsapp']) ? 'true' : 'false' }},
                                email: '{{ $oldContact['email'] ?? '' }}',
                            },
                        @endforeach
                    @else
                    @if (count($supplier->supplierContacts) > 0)
                    @foreach ($supplier->supplierContacts as $supplierContact)
                       {
                       name: '{{ $supplierContact->name }}',
                       telephone: '{{ $supplierContact->telephone }}',
                       celphone: '{{ $supplierContact->celphone }}',
                       whatsapp: {{ $supplierContact->whatsapp === 1 ? 'true' : 'false' }},
                       email: '{{ $supplierContact->email }}',
                    }, @endforeach 
                    @else {
                        name: '',
                        telephone: '',
                        celphone: '',
                        whatsapp: 'false',
                        email: '',
                    }, @endif
                    @endif
            
                ]
            }">
                <template x-for="(contact, index) in contacts" :key="index">
                    <div class="row justify-content-center mb-2">
                        <div class="mb-2">
                            <h6 class="text-center">Informações do Contato <span x-text="index + 1"></span>
                                <template x-if="contacts.length > 1">
                                    <button type="button" title="Excluir contato" class="btn btn-sm btn-danger"
                                        @click="contacts.splice(index, 1)">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </template>
                            </h6>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" class="form-control rounded-3"
                                    x-model="contact.name" :name="'contacts[' + index + '][name]'">
                                <label>Nome da pessoa/do setor</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" class="form-control rounded-3 telephone"
                                    x-mask="(99) 9999-9999" x-model="contact.telephone"
                                    :name="'contacts[' + index + '][telephone]'"
                                    oninput="this.value = this.value.toUpperCase()">
                                <label>Telefone</label>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control rounded-3 celphone"
                                    x-model="contact.celphone" x-mask="(99) 9 9999-9999"
                                    :name="'contacts[' + index + '][celphone]'">
                                <label>Celular</label>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" x-model="contact.whatsapp"
                                    :name="'contacts[' + index + '][whatsapp]'">
                                <label class="form-check-label">Whatsapp</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="email" class="form-control rounded-3"
                                    x-model="contact.email" :name="'contacts[' + index + '][email]'">
                                <label>E-mail</label>
                            </div>
                        </div>
                        <div class="mb-5 text-center">
                            <template x-if="index === contacts.length - 1">
                                <button type="button" title="Adicionar mais um contato" class="btn btn-sm btn-primary"
                                    @click="contacts.push({ name: '', telephone: '', celphone: '', whatsapp: false, email: '' });
                                    setTimeout(function() {
                                        $('.select2row').select2({
                                            theme: 'bootstrap-5'
                                        });
                                    }, 0);">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
            <div class="text-center">
                <button class="btn btn-lg btn-success rounded-3" title="Editar fornecedor" type="submit"
                    onclick="this.innerText = 'Editando...'">Editar</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            //CONTROLES DE APARECIMENTO DE DIVS ------------------- INÍCIO
            var $selectVisible = $("#contacting");
            $selectVisible.change(function() {
                var value = $(this).val();
                if (value === "Sim") {
                    $(".contacts-fields").show();
                } else {
                    $(".contacts-fields").hide();
                }
            });

            $selectVisible.change();
            //CONTROLES DE APARECIMENTO DE DIVS ------------------- FIM
        });
    </script>
@endpush
