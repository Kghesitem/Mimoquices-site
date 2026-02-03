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
                    <a class="text-decoration-none text-dark" href="javascript:void(0)" onclick="copiarEmail()">
                            info@mimoquices.pt
                    </a>
                    <h4 class="mb-0 mt-3">Redes Sociais</h4>
                    <div class="d-flex gap-1">
                        <a class="social-links" href="https://www.instagram.com/mimoquices.mv/" target="_blank"><img src="{{ asset('frontend/assets/img/instagram.png')}}" alt=""></a>
                        <a class="social-links" href="https://www.facebook.com/mimoquicesmv/" target="_blank"><img src="{{ asset('frontend/assets/img/facebook.png')}}" alt=""></a>
                        <a class="social-links" href="javascript:void(0)" onclick="copiarEmail()">
                            <img src="{{ asset('frontend/assets/img/email.png') }}" alt="Email">
                        </a>
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
    const email = 'info@mimoquices.pt';

    navigator.clipboard.writeText(email).then(() => {
        const toast = document.getElementById('toast-email');
        toast.classList.add('active');

        setTimeout(() => {
            toast.classList.remove('active');
        }, 1000);
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>