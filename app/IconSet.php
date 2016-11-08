<?php

namespace App;

class IconSet
{
    public static $icons = [
        'fa-area-chart',
        'fa-bar-chart',
        'fa-bolt',
        'fa-book',
        'fa-bookmark',
        'fa-briefcase',
        'fa-bug',
        'fa-building',
        'fa-calculator',
        'fa-calendar-plus-o',
        'fa-camera',
        'fa-certificate',
        'fa-check',
        'fa-circle',
        'fa-circle-o',
        'fa-clock-o',
        'fa-clone',
        'fa-cloud',
        'fa-cloud-download',
        'fa-cloud-upload',
        'fa-code',
        'fa-code-fork',
        'fa-cog',
        'fa-cogs',
        'fa-comment',
        'fa-cube',
        'fa-database',
        'fa-desktop',
        'fa-dot-circle-o',
        'fa-download',
        'fa-ellipsis-h',
        'fa-ellipsis-v',
        'fa-envelope',
        'fa-eraser',
        'fa-exchange',
        'fa-exclamation-triangle',
        'fa-external-link',
        'fa-fax',
        'fa-feed',
        'fa-flag',
        'fa-flask',
        'fa-folder',
        'fa-folder-open',
        'fa-glass',
        'fa-globe',
        'fa-graduation-cap',
        'fa-hdd-o',
        'fa-heart',
        'fa-history',
        'fa-home',
        'fa-inbox',
        'fa-info-circle',
        'fa-key',
        'fa-laptop',
        'fa-line-chart',
        'fa-location-arrow',
        'fa-lock',
        'fa-magnet',
        'fa-map-o',
        'fa-map-marker',
        'fa-minus-circle',
        'fa-mouse-pointer',
        'fa-music',
        'fa-paper-plane',
        'fa-pencil',
        'fa-phone',
        'fa-pie-chart',
        'fa-plane',
        'fa-plug',
        'fa-plus-circle',
        'fa-power-off',
        'fa-print',
        'fa-quote-right',
        'fa-random',
        'fa-refresh',
        'fa-rss',
        'fa-search',
        'fa-server',
        'fa-shield',
        'fa-signal',
        'fa-sort',
        'fa-star',
        'fa-star-half-o',
        'fa-star-o',
        'fa-sticky-note',
        'fa-suitcase',
        'fa-tag',
        'fa-tags',
        'fa-tasks',
        'fa-television',
        'fa-terminal',
        'fa-thumb-tack',
        'fa-times',
        'fa-tree',
        'fa-trophy',
        'fa-university',
        'fa-unlock-alt',
        'fa-upload',
        'fa-user',
        'fa-wrench',
    ];

    public static function exists($icon)
    {
        return in_array($icon, IconSet::$icons);
    }
}
