<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container3pxh2k8\appDevDebugProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container3pxh2k8/appDevDebugProjectContainer.php') {
    touch(__DIR__.'/Container3pxh2k8.legacy');

    return;
}

if (!\class_exists(appDevDebugProjectContainer::class, false)) {
    \class_alias(\Container3pxh2k8\appDevDebugProjectContainer::class, appDevDebugProjectContainer::class, false);
}

return new \Container3pxh2k8\appDevDebugProjectContainer([
    'container.build_hash' => '3pxh2k8',
    'container.build_id' => 'f11f0670',
    'container.build_time' => 1672651265,
], __DIR__.\DIRECTORY_SEPARATOR.'Container3pxh2k8');
