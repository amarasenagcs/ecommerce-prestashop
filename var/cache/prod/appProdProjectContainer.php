<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container9yfnfko\appProdProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container9yfnfko/appProdProjectContainer.php') {
    touch(__DIR__.'/Container9yfnfko.legacy');

    return;
}

if (!\class_exists(appProdProjectContainer::class, false)) {
    \class_alias(\Container9yfnfko\appProdProjectContainer::class, appProdProjectContainer::class, false);
}

return new \Container9yfnfko\appProdProjectContainer([
    'container.build_hash' => '9yfnfko',
    'container.build_id' => '77e347d2',
    'container.build_time' => 1672653648,
], __DIR__.\DIRECTORY_SEPARATOR.'Container9yfnfko');
