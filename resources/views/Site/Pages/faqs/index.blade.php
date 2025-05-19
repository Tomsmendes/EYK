@extends('layouts.app')

@section('title', 'Listagem de Faqs')

@section('content')
<div class="container mt-5">
    <h1>Listagem de Faqs</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#faqModal" onclick="prepareModal('create', '{{ route('faqs.store') }}')">Novo Faqs</button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
            <th scope="col">#</th>
                    <th scope="col">Questão</th>
                    <th scope="col">Resposta</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Ordem</th>
                    <th scope="col">opcão</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($faqs as $faq)
                <tr>
                    <th>{{ $faq->id }}</th>
                    <th>{{ $faq->question }}</th>
                    <th>{{ $faq->answer }}</th>
                    <th>{{ $faq->category_f }}</th>
                    <th>{{ $faq->order }}</th>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#faqModal"
                            onclick="prepareModal('edit', '{{ route('faqs.update', $faq) }}', {{ json_encode($faq) }})">Editar</button>
                        <form action="{{ route('faqs.destroy', $faq) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

   <!-- Modal -->
<div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="faqForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="faqModalLabel">Novo faq</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Questão</label>
                        <input type="text" class="form-control" id="question" name="question" required>
                    </div>

                    <div class="mb-3">
                        <label for="answer" class="form-label">Resposta</label>
                        <input type="text" class="form-control" id="answer" name="answer" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_f" class="form-label">Categoria</label>
                        <input type="text" class="form-control" id="category_f" name="category_f" required>
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label">Ordem</label>
                        <input type="number" class="form-control" id="order" name="order" step="0.01">
                    </div>

                    <div class="mb-3 text-center">
                        <img id="thumbnailPreview" src="#" alt="Pré-visualização da thumbnail" style="display: none; width: 150px; height: auto;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript para preview e edição -->
<script>
function prepareModal(mode, url, faq = null) {
    const form = document.getElementById('faqForm');
    const modalTitle = document.getElementById('faqModalLabel');
    const formMethod = document.getElementById('formMethod');
    const preview = document.getElementById('thumbnailPreview');

    form.action = url;
    form.reset();
    preview.style.display = 'none';
    preview.src = "#";

    if (mode === 'create') {
        modalTitle.textContent = 'Novo faq';
        formMethod.value = 'POST';
    } else {
        modalTitle.textContent = 'Editar faq';
        formMethod.value = 'PUT';

        document.getElementById('question').value = faq.question;
        document.getElementById('answer').value = faq.answer;
        document.getElementById('category_f').value = faq.category_f;
        document.getElementById('order').value = faq.order;
    }
}
</script>

@endsection
