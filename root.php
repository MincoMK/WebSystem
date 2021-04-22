<pre>
<?php
echo "Document Root: {$_SERVER['DOCUMENT_ROOT']}\n";
echo "__DIR__: " . __DIR__ . "\n";
echo "__FILE__: " . __FILE__ . "\n";
?>
<?= var_dump($_SERVER) ?>
</pre>
