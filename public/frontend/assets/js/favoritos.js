document.querySelectorAll('.favorite-btn').forEach(btn => {
    // Mudámos para arrow function () => para manter o contexto, ou usamos o event diretamente
    btn.addEventListener('click', function(event) {
        event.stopPropagation();
        event.preventDefault();

        const produtoId = this.closest('.produtos-produto').dataset.produtoId;
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
                // CORREÇÃO: Condição invertida (caso o Swal NÃO esteja definido, faz o fallback primeiro)
                if (typeof Swal === 'undefined') {
                    alert('Precisas de iniciar sessão!');
                    globalThis.location.href = '/login'; // CORREÇÃO: Usar globalThis
                    return null;
                }

                // Fluxo principal com SweetAlert
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
                        globalThis.location.href = '/login'; // CORREÇÃO: Usar globalThis
                    }
                });

                return null;
            }

            return response.json();
        })
        .then(data => {
            // CORREÇÃO: Removido o "this to button" e aplicado o Optional Chaining (?.)
            if (data?.status === 'added') {
                this.classList.add('active');
            } else if (data?.status === 'removed') {
                this.classList.remove('active');
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
    });
});
