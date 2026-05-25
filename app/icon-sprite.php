<?php
declare(strict_types=1);

if (!function_exists('ironinvest_svg_sprite')) {
    function ironinvest_svg_sprite(): void
    {
        ?>
        <svg class="svg-sprite" aria-hidden="true" focusable="false">
            <symbol id="icon-trend" viewBox="0 0 24 24">
                <path d="M3 17L9 11L13 15L21 7" />
                <path d="M15 7H21V13" />
            </symbol>
            <symbol id="icon-trend-down" viewBox="0 0 24 24">
                <path d="M3 7L9 13L13 9L21 17" />
                <path d="M15 17H21V11" />
            </symbol>
            <symbol id="icon-pulse" viewBox="0 0 24 24">
                <path d="M3 13H7L9.5 6L14 18L16.5 10H21" />
            </symbol>
            <symbol id="icon-shield" viewBox="0 0 24 24">
                <path d="M12 3.5L5.5 6.2V11C5.5 15.5 8.2 19.4 12 20.7C15.8 19.4 18.5 15.5 18.5 11V6.2L12 3.5Z" />
            </symbol>
            <symbol id="icon-award" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="4" />
                <path d="M9.4 11.5L7.8 20L12 17.7L16.2 20L14.6 11.5" />
            </symbol>
            <symbol id="icon-book" viewBox="0 0 24 24">
                <path d="M5 5.5H10C11.1 5.5 12 6.4 12 7.5V19C12 17.9 11.1 17 10 17H5V5.5Z" />
                <path d="M19 5.5H14C12.9 5.5 12 6.4 12 7.5V19C12 17.9 12.9 17 14 17H19V5.5Z" />
            </symbol>
            <symbol id="icon-eye" viewBox="0 0 24 24">
                <path d="M3.5 12C5.5 8.8 8.4 7.2 12 7.2C15.6 7.2 18.5 8.8 20.5 12C18.5 15.2 15.6 16.8 12 16.8C8.4 16.8 5.5 15.2 3.5 12Z" />
                <circle cx="12" cy="12" r="2.4" />
            </symbol>
            <symbol id="icon-building" viewBox="0 0 24 24">
                <path d="M5 20V7.5L12 4L19 7.5V20" />
                <path d="M8 20V10H16V20" />
                <path d="M10 12H14" />
                <path d="M10 15H14" />
                <path d="M3.5 20H20.5" />
            </symbol>
            <symbol id="icon-target" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="8" />
                <circle cx="12" cy="12" r="4.5" />
                <circle cx="12" cy="12" r="1.6" />
            </symbol>
            <symbol id="icon-lightbulb" viewBox="0 0 24 24">
                <path d="M9 18H15" />
                <path d="M10 21H14" />
                <path d="M8.5 14.6C7.2 13.5 6.5 12 6.5 10.2C6.5 7.1 8.9 4.8 12 4.8C15.1 4.8 17.5 7.1 17.5 10.2C17.5 12 16.8 13.5 15.5 14.6C14.8 15.2 14.5 15.9 14.5 16.8H9.5C9.5 15.9 9.2 15.2 8.5 14.6Z" />
            </symbol>
            <symbol id="icon-heart" viewBox="0 0 24 24">
                <path d="M12 20C12 20 5 15.8 5 9.7C5 7.2 6.9 5.4 9.2 5.4C10.5 5.4 11.5 6 12 7C12.5 6 13.5 5.4 14.8 5.4C17.1 5.4 19 7.2 19 9.7C19 15.8 12 20 12 20Z" />
            </symbol>
            <symbol id="icon-handshake" viewBox="0 0 24 24">
                <path d="M7.5 13.5L10.7 16.7C11.4 17.4 12.5 17.4 13.2 16.7L18.5 11.4" />
                <path d="M9.5 11.5L11.2 9.8C12.1 8.9 13.5 8.9 14.4 9.8L15.6 11" />
                <path d="M3.8 12.4L7.2 9L10.1 11.9" />
                <path d="M20.2 12.4L16.8 9L15.2 10.6" />
                <path d="M8.8 14.8L7.6 16" />
                <path d="M11.2 17.2L10 18.4" />
            </symbol>
            <symbol id="icon-check-circle" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="8" />
                <path d="M8.5 12.2L11 14.7L15.8 9.7" />
            </symbol>
            <symbol id="icon-lock" viewBox="0 0 24 24">
                <rect x="6" y="10" width="12" height="9" rx="2" />
                <path d="M9 10V8.2C9 6.4 10.2 5 12 5C13.8 5 15 6.4 15 8.2V10" />
            </symbol>
            <symbol id="icon-star" viewBox="0 0 24 24">
                <path d="M12 4L14.4 9L20 9.8L16 13.8L16.9 19.4L12 16.8L7.1 19.4L8 13.8L4 9.8L9.6 9L12 4Z" />
            </symbol>
            <symbol id="icon-calendar" viewBox="0 0 24 24">
                <rect x="4" y="5.5" width="16" height="15" rx="2.5" />
                <path d="M8 3.5V7.5" />
                <path d="M16 3.5V7.5" />
                <path d="M4 10H20" />
            </symbol>
            <symbol id="icon-clock" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="8" />
                <path d="M12 7.5V12L15 14" />
            </symbol>
            <symbol id="icon-users" viewBox="0 0 24 24">
                <circle cx="9" cy="8" r="3" />
                <path d="M4 18C4.5 15.8 6.4 14.5 9 14.5C11.6 14.5 13.5 15.8 14 18" />
                <path d="M15 6.2C17.1 6.6 18.5 8 18.5 10C18.5 11.1 18 12.1 17.2 12.7" />
                <path d="M16.5 15C18.5 15.4 19.8 16.5 20.2 18" />
            </symbol>
            <symbol id="icon-graduation" viewBox="0 0 24 24">
                <path d="M3 9L12 5L21 9L12 13L3 9Z" />
                <path d="M7 11.5V15.5C8.5 17 10.1 17.7 12 17.7C13.9 17.7 15.5 17 17 15.5V11.5" />
            </symbol>
            <symbol id="icon-video" viewBox="0 0 24 24">
                <rect x="4" y="7" width="12" height="10" rx="2" />
                <path d="M16 10L20 7.8V16.2L16 14V10Z" />
            </symbol>
            <symbol id="icon-document" viewBox="0 0 24 24">
                <path d="M7 4H15L18 7V20H7V4Z" />
                <path d="M15 4V8H18" />
                <path d="M10 12H15" />
                <path d="M10 15H15" />
            </symbol>
            <symbol id="icon-download" viewBox="0 0 24 24">
                <path d="M12 4V15" />
                <path d="M8 11L12 15L16 11" />
                <path d="M5 18.5H19" />
            </symbol>
            <symbol id="icon-play" viewBox="0 0 24 24">
                <path d="M8 5L19 12L8 19V5Z" />
            </symbol>
            <symbol id="icon-question" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="8" />
                <path d="M9.8 9.4C10.1 8.3 10.9 7.6 12.1 7.6C13.5 7.6 14.4 8.5 14.4 9.7C14.4 11.5 12.2 11.8 12.2 13.5" />
                <path d="M12.2 16.4H12.3" />
            </symbol>
            <symbol id="icon-search" viewBox="0 0 24 24">
                <circle cx="10.8" cy="10.8" r="6.2" />
                <path d="M15.4 15.4L20 20" />
            </symbol>
            <symbol id="icon-credit-card" viewBox="0 0 24 24">
                <rect x="4" y="6.5" width="16" height="11" rx="2" />
                <path d="M4 10H20" />
                <path d="M7 14.5H12" />
            </symbol>
            <symbol id="icon-message" viewBox="0 0 24 24">
                <path d="M5 19L6.2 15.8C5.4 14.6 5 13.3 5 12C5 8.2 8.1 5.2 12 5.2C15.9 5.2 19 8.2 19 12C19 15.8 15.9 18.8 12 18.8C10.7 18.8 9.5 18.5 8.5 17.9L5 19Z" />
            </symbol>
            <symbol id="icon-map-pin" viewBox="0 0 24 24">
                <path d="M12 21C12 21 18 15.6 18 10.5C18 7.2 15.3 4.5 12 4.5C8.7 4.5 6 7.2 6 10.5C6 15.6 12 21 12 21Z" />
                <circle cx="12" cy="10.5" r="2" />
            </symbol>
            <symbol id="icon-phone" viewBox="0 0 24 24">
                <path d="M7.5 5.5L10 8L8.5 10.2C9.5 12.4 11.2 14.1 13.8 15.5L16 14L18.5 16.5L17.4 19.1C17.1 19.8 16.3 20.2 15.5 20C9.8 18.8 5.2 14.2 4 8.5C3.8 7.7 4.2 6.9 4.9 6.6L7.5 5.5Z" />
            </symbol>
            <symbol id="icon-mail" viewBox="0 0 24 24">
                <rect x="4" y="6.5" width="16" height="11" rx="2" />
                <path d="M5 8L12 13L19 8" />
            </symbol>
            <symbol id="icon-facebook" viewBox="0 0 24 24">
                <path d="M14.5 5H13C11.1 5 10 6.2 10 8.2V10.5H7.8V13H10V20H12.8V13H15L15.4 10.5H12.8V8.4C12.8 7.7 13.1 7.4 13.8 7.4H14.5V5Z" />
            </symbol>
            <symbol id="icon-instagram" viewBox="0 0 24 24">
                <rect x="5" y="5" width="14" height="14" rx="4" />
                <circle cx="12" cy="12" r="3" />
                <path d="M16.5 7.8H16.6" />
            </symbol>
            <symbol id="icon-x" viewBox="0 0 24 24">
                <path d="M6 6L18 18" />
                <path d="M18 6L6 18" />
            </symbol>
            <symbol id="icon-youtube" viewBox="0 0 24 24">
                <rect x="4" y="7" width="16" height="10" rx="3" />
                <path d="M10.5 10L14.5 12L10.5 14V10Z" />
            </symbol>
            <symbol id="icon-linkedin" viewBox="0 0 24 24">
                <path d="M6.5 10V18" />
                <path d="M6.5 6.5V6.6" />
                <path d="M10.5 18V10" />
                <path d="M10.5 13.4C10.5 11.4 11.8 10 13.9 10C16 10 17.5 11.5 17.5 14.1V18" />
            </symbol>
        </svg>
        <?php
    }
}

if (!function_exists('ironinvest_icon')) {
    function ironinvest_icon(string $id, string $class = 'site-icon'): void
    {
        $safeId = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
        $safeClass = htmlspecialchars($class, ENT_QUOTES, 'UTF-8');
        echo '<svg class="' . $safeClass . '" focusable="false"><use href="#' . $safeId . '"></use></svg>';
    }
}
