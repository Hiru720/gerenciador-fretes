</main>
<footer class="text-center text-muted small py-3">Gerenciador de Fretes - Projeto de Fundamentos de Programação para Internet</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/js/mascaras.js"></script>
<?php foreach (($scripts ?? []) as $arquivo): ?>
<script src="<?= BASE_URL ?>/js/<?= e($arquivo) ?>"></script>
<?php endforeach; ?>
</body>
</html>
