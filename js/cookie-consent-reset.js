(function ($) {
    'use strict';
    wp.customize.preview.bind('ready', function () {

        // สร้างปุ่ม
        var btn = $('#slatan-reset-cookie');

        // เช็คว่ามี Cookie ไหม
        function checkCookie() {
            if (document.cookie.indexOf('slatan_cookie_consent=') >= 0) {
                btn.addClass('is-visible');
            } else {
                btn.removeClass('is-visible');
            }
        }

        // เช็คตอนโหลด
        checkCookie();

        // คลิกปุ่ม Reset
        btn.on('click', function (e) {
            e.preventDefault();
            // ลบ Cookie
            document.cookie = 'slatan_cookie_consent=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            alert('Cookie Consent Reset! Please refresh the preview.');
            location.reload();
        });

    });
})(jQuery);
