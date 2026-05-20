<?php
/**
 * includes/footer.php  — closing </body> + scripts
 */
if (!isset($__assetBase)) {
    $__script    = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $__parts     = explode('/', trim($__script, '/'));
    $__assetBase = '/' . $__parts[0] . '/';
}
?>
  <script src="<?= $__assetBase ?>assets/js/app.js"></script>
</body>
</html>
