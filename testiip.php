<?php
if (function_exists('opcache_get_status')) {
    $status = opcache_get_status();
    if ($status && $status['opcache_enabled']) {
        echo "✅ OPcache is enabled.";
    } else {
        echo "❌ OPcache is disabled.";
    }
} else {
    echo "🚫 OPcache not available.";
}
?>
