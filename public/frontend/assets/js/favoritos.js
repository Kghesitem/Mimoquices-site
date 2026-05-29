document.querySelectorAll('.favorite-btn').forEach(btn => {
    btn.addEventListener('click', function(event) {
        event.stopPropagation(); 
        event.preventDefault();
        
        const produtoId = this.closest('.produtos-produto').dataset.produtoId;
        const button = this;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!csrfToken) {
            console.error('Erro: Token CSRF não encontrado no HTML.');
            return;
        }

        fetch('/favoritos/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ id_produto: produtoId })
        })
        .then(response => {
            if (response.status === 401) {
                // Se o SweetAlert estiver carregado, usa-o
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Precisas de iniciar sessão para guardar favoritos.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ir para Login',
                        cancelButtonText: 'Continuar a ver',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/login';
                        }
                    });
                } else {
                    // Fallback se o Swal falhar
                    alert('Precisas de iniciar sessão!');
                    window.location.href = '/login';
                }
                return null;
            }
            return response.json();
        })
        .then(data => {
            if (data && data.status === 'added') {
                button.classList.add('active');
            } else if (data && data.status === 'removed') {
                button.classList.remove('active');
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
    });
});