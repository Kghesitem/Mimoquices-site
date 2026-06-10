<footer class="bg-white border-top border-2" style="border-color: #c89286; min-height: 200px;">
        <div class="container-fluid h-100">
            <div class="row h-100 justify-content-evenly align-items-center py-4">
                <div class="col-auto d-flex flex-column gap-2">
                    <h4 class="mb-0">Site</h4>
                    <a href="{{ route('welcome') }}" class="text-decoration-none text-dark">Pagina principal</a>
                    <a href="{{ route('sobre') }}" class="text-decoration-none text-dark">Sobre nós</a>
                    <a href="{{ route('produto.index') }}" class="text-decoration-none text-dark">Produtos</a>
                </div>

                <div class="col-auto d-flex flex-column gap-2">
                    <h4 class="mb-0">Contacto</h4>

                    {{-- Corrigido: Alterado de <a> para <button> com reset de estilos --}}
                    <button class="text-decoration-none text-dark" onclick="copiarEmail()" style="background: none; border: none; padding: 0; text-align: left; font-family: inherit; font-size: inherit; cursor: pointer;">
                        info@mimoquices.pt
                    </button>

                    <h4 class="mb-0 mt-3">Redes Sociais</h4>
                    <div class="d-flex gap-1">
                        {{-- Corrigido: Adicionados atributos 'alt' semânticos nas imagens --}}
                        <a class="social-links" href="https://www.instagram.com/mimoquices.mv/" target="_blank">
                            <img src="{{ asset('frontend/assets/img/instagram.png')}}" alt="Instagram da Mimoquices">
                        </a>

                        <a class="social-links" href="https://www.facebook.com/mimoquicesmv/" target="_blank">
                            <img src="{{ asset('frontend/assets/img/facebook.png')}}" alt="Facebook da Mimoquices">
                        </a>

                        {{-- Corrigido: Alterado de <a> para <button> para ações de JavaScript --}}
                        <button class="social-links" onclick="copiarEmail()" style="background: none; border: none; padding: 0; cursor: pointer;" aria-label="Copiar endereço de e-mail">
                            <img src="{{ asset('frontend/assets/img/email.png') }}" alt="Ícone de E-mail">
                        </button>

                    {{-- Toast customizado --}}
                    <div id="toast-email" class="toast-email">
                        Email copiado com sucesso
                    </div>

                    </div>
                </div>
            </div>
        </div>
</footer>

<script>
function copiarEmail() {
    const email = "info@mimoquices.pt";

    navigator.clipboard.writeText(email).then(() => {
        Swal.fire({
            icon: 'success',
            title: 'Copiado!',
            text: 'Email copiado com sucesso',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }).catch(err => {
        console.error('Erro ao copiar email: ', err);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Não foi possível copiar o email.',
        });
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
