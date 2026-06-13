<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="error-debug">

<h4 class="error-debug-title">An uncaught Exception was encountered</h4>

<p class="error-debug-line">Type: <?php echo get_class($exception); ?></p>
<p class="error-debug-line">Message: <?php echo $message; ?></p>
<p class="error-debug-line">Filename: <?php echo $exception->getFile(); ?></p>
<p class="error-debug-line">Line Number: <?php echo $exception->getLine(); ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p class="error-debug-line">Backtrace:</p>
	<?php foreach ($exception->getTrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p class="error-debug-indent">
			File: <?php echo $error['file']; ?><br />
			Line: <?php echo $error['line']; ?><br />
			Function: <?php echo $error['function']; ?>
			</p>
		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>
