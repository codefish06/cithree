<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="border-2 border-red-900 pl-5 mb-2">

<h4 class="font-bold text-lg mb-3">An uncaught Exception was encountered</h4>

<p class="mb-2">Type: <?php echo get_class($exception); ?></p>
<p class="mb-2">Message: <?php echo $message; ?></p>
<p class="mb-2">Filename: <?php echo $exception->getFile(); ?></p>
<p class="mb-2">Line Number: <?php echo $exception->getLine(); ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p class="mb-2">Backtrace:</p>
	<?php foreach ($exception->getTrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p class="ml-2 mb-2">
			File: <?php echo $error['file']; ?><br />
			Line: <?php echo $error['line']; ?><br />
			Function: <?php echo $error['function']; ?>
			</p>
		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>