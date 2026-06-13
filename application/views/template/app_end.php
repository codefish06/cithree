<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$arrExtraScripts = isset($extra_scripts) && is_array($extra_scripts) ? $extra_scripts : [];
$arrExtraInlineScripts = isset($extra_inline_scripts) && is_array($extra_inline_scripts) ? $extra_inline_scripts : [];
?>
            <footer class="mt-5 pt-4 border-top text-secondary small">
                <div class="d-flex flex-column flex-md-row justify-content-md-between gap-2">
                    <span>Page rendered in <strong>{elapsed_time}</strong> seconds.</span>
                    <?php if (ENVIRONMENT === 'development') { ?>
                        <span>CodeIgniter <strong><?php echo CI_VERSION; ?></strong> · <?php echo APP_NAME; ?> <strong><?php echo APP_VERSION; ?></strong></span>
                    <?php } ?>
                </div>
            </footer>
        </main>
    </div>
</div>

<script src="<?php echo base_url('application/assets/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('application/assets/js/theme.js'); ?>"></script>
<?php foreach ($arrExtraScripts as $strScriptSrc) { ?>
    <script src="<?php echo $strScriptSrc; ?>"></script>
<?php } ?>
<?php foreach ($arrExtraInlineScripts as $strInlineScript) { ?>
    <script>
<?php echo $strInlineScript; ?>
    </script>
<?php } ?>
</body>
</html>
