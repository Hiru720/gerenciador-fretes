// Tela de novo frete: adiciona e remove linhas de produto dinamicamente
document.addEventListener('DOMContentLoaded', () => {
    const lista = document.getElementById('listaProdutos');
    const modelo = document.getElementById('modeloLinha');
    const botaoAdicionar = document.getElementById('btnAdicionar');
    if (!lista || !modelo || !botaoAdicionar) return;

    function adicionarLinha() {
        lista.appendChild(modelo.content.cloneNode(true));
    }

    botaoAdicionar.addEventListener('click', adicionarLinha);

    lista.addEventListener('click', (evento) => {
        const botao = evento.target.closest('.btn-remover');
        if (!botao) return;
        // sempre deixa pelo menos uma linha
        if (lista.querySelectorAll('.linha-produto').length > 1) {
            botao.closest('.linha-produto').remove();
        }
    });

    adicionarLinha(); // começa com uma linha
});
