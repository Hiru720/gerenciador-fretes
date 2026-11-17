// Máscaras simples para CEP, CNPJ, telefone e placa (só visual, não valida)
const mascaras = {
    cep: (v) => v.slice(0, 8).replace(/^(\d{5})(\d)/, '$1-$2'),
    cnpj: (v) => v.slice(0, 14)
        .replace(/^(\d{2})(\d)/, '$1.$2')
        .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
        .replace(/\.(\d{3})(\d)/, '.$1/$2')
        .replace(/(\d{4})(\d)/, '$1-$2'),
    telefone: (v) => v.slice(0, 11)
        .replace(/^(\d{2})(\d)/, '($1) $2')
        .replace(/(\d{4,5})(\d{4})$/, '$1-$2'),
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-mascara]').forEach((campo) => {
        const tipo = campo.dataset.mascara;
        campo.addEventListener('input', () => {
            if (tipo === 'placa') {
                campo.value = campo.value.toUpperCase();
            } else if (mascaras[tipo]) {
                campo.value = mascaras[tipo](campo.value.replace(/\D/g, ''));
            }
        });
    });
});
