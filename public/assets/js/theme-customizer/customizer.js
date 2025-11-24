(function ($) {
    "use strict";

    // ========================================
    // 1. إضافة لوحة الإعدادات إلى الصفحة
    // ========================================
    const settingsHTML = `
<div class="sidebar-pannle-main">
    <ul>
        <li class="cog-click icon-btn btn-primary" id="cog-click">
            <i class="fa-solid fa-spin fa-cog"></i>
        </li>
    </ul>
</div>

<section class="setting-sidebar">
    <div class="customizer-header">
        <div class="theme-title">
            <div class="flex-grow-1">
                <a class="icon-btn btn-outline-light button-effect pull-right cog-close" id="cog-close">
                    <i class="fa-solid fa-xmark fa-fw"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="customizer-body">
        <!-- Light / Dark / Mix -->
       <!--   <div class="mb-3 p-2 rounded-3 b-t-primary border-3">
            <div class="color-body d-flex align-items-center justify-content-between">

            </div>
        </div>-->

        <!-- Sidebar Icon (Stroke / Colorful) -->
        <!--  <div class="mb-3 p-2 rounded-3 b-t-primary border-3">
            <div class="sidebar-icon mb-2">
                <h4>Sidebar icon:</h4>
                <p>Choose between 2 different sidebar icons.</p>
            </div>
            <div class="sidebar-body form-check radio ps-0">
                <ul class="radio-wrapper">
                    <li class="default-svg">
                        <input class="form-check-input" id="radio-icon5" type="radio" name="sidebarIcon" value="stroke" checked>
                        <label class="form-check-label" for="radio-icon5">
                            <svg class="stroke-icon"><use href="/assets/svg/icon-sprite.svg#stroke-icons"></use></svg>
                            <span>Stroke</span>
                        </label>
                    </li>
                    <li class="colorfull-svg">
                        <input class="form-check-input" id="radio-icon6" type="radio" name="sidebarIcon" value="colorful">
                        <label class="form-check-label" for="radio-icon6">
                            <svg class="stroke-icon"><use href="/assets/svg/icon-sprite.svg#fill-icons"></use></svg>
                            <span>Colorful icon</span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
        -->

        <!-- Layout Type (LTR / RTL / Box) -->
       <!--   <div class="mb-3 p-2 rounded-3 b-t-primary border-3">
            <div class="theme-layout mb-2">
                <h4>Layout type:</h4>
                <p>Choose between 3 different layout types.</p>
            </div>
            <div class="radio-form checkbox-checked">
                <div class="form-check ltr-setting">
                    <input class="form-check-input" id="flexRadioDefault1" type="radio" name="layoutType" value="ltr" checked>
                    <label class="form-check-label" for="flexRadioDefault1">LTR</label>
                </div>
                <div class="form-check rtl-setting">
                    <input class="form-check-input" id="flexRadioDefault2" type="radio" name="layoutType" value="rtl">
                    <label class="form-check-label" for="flexRadioDefault2">RTL</label>
                </div>
                <div class="form-check box-setting">
                    <input class="form-check-input" id="flexRadioDefault3" type="radio" name="layoutType" value="box">
                    <label class="form-check-label" for="flexRadioDefault3">Box</label>
                </div>
            </div>
        </div>
        -->

        <!-- Sidebar Type (Vertical / Horizontal) -->
       <!--   <div class="mb-3 p-2 rounded-3 b-t-primary border-3">
            <div class="sidebar-type mb-2">
                <h4>Sidebar type:</h4>
                <p>Choose between 2 different sidebar types.</p>
            </div>
            <div class="sidebar-body form-check radio ps-0">
                <ul class="radio-wrapper">
                    <li class="vertical-setting">
                        <input class="form-check-input" id="sidebar-vertical" type="radio" name="sidebarType" value="vertical" checked>
                        <label class="form-check-label" for="sidebar-vertical"><span>Vertical</span></label>
                    </li>
                    <li class="horizontal-setting">
                        <input class="form-check-input" id="sidebar-horizontal" type="radio" name="sidebarType" value="horizontal">
                        <label class="form-check-label" for="sidebar-horizontal"><span>Horizontal</span></label>
                    </li>
                </ul>
            </div>
        </div>-->

        <!-- Unlimited Color Picker -->
        <div class="customizer-color mb-3 p-2 rounded-3 b-t-primary border-3">
            <div class="color-picker mb-2">
                <h4>Unlimited color:</h4>
            </div>
            <ul class="layout-grid customizer-color">
                <li class="color-layout active" data-attr="color-1" data-primary="#308e87" data-secondary="#f39159"><div></div></li>
                <li class="color-layout" data-attr="color-2" data-primary="#57375D" data-secondary="#FF9B82"><div></div></li>
                <li class="color-layout" data-attr="color-3" data-primary="#0766AD" data-secondary="#29ADB2"><div></div></li>
                <li class="color-layout" data-attr="color-4" data-primary="#025464" data-secondary="#E57C23"><div></div></li>
                <li class="color-layout" data-attr="color-5" data-primary="#884A39" data-secondary="#C38154"><div></div></li>
                <li class="color-layout" data-attr="color-6" data-primary="#0C356A" data-secondary="#FFC436"><div></div></li>
            </ul>
        </div>
    </div>


</section>`;

    // إضافة الـ HTML للـ body
    $("body").append(settingsHTML);

    // ========================================
    // 2. تطبيق الإعدادات المحفوظة عند التحميل
    // ========================================
    $(document).ready(function () {

        // تطبيق اللون المحفوظ
        if (localStorage.getItem("color")) {
            const color = localStorage.getItem("color");
            $("#color").attr("href", "/assets/css/" + color + ".css");
        }

        // تطبيق Primary & Secondary
        if (localStorage.getItem("primary")) {
            document.documentElement.style.setProperty("--theme-default", localStorage.getItem("primary"));
        }
        if (localStorage.getItem("secondary")) {
            document.documentElement.style.setProperty("--theme-secondary", localStorage.getItem("secondary"));
        }

        // ========================================
        // فتح وإغلاق اللوحة
        // ========================================
        $("#cog-click").on("click", function () {
            $(".setting-sidebar").addClass("open");
        });

        $("#cog-close").on("click", function () {
            $(".setting-sidebar").removeClass("open");
        });

        // ========================================
        // ألوان مخصصة (Unlimited Color)
        // ========================================
        $(".customizer-color .color-layout").on("click", function () {
            $(".customizer-color .color-layout").removeClass("active");
            $(this).addClass("active");

            const color = $(this).data("attr");
            const primary = $(this).data("primary");
            const secondary = $(this).data("secondary");

            localStorage.setItem("color", color);
            localStorage.setItem("primary", primary);
            localStorage.setItem("secondary", secondary);
            localStorage.removeItem("dark");

            $("#color").attr("href", "/assets/css/" + color + ".css");
            location.reload(true);
        });

        // ========================================
        // Light / Dark / Mix Mode
        // ========================================
        $(".light-setting").on("click", function () {
            $("body").attr("data-theme", "light").removeClass("dark-only dark-sidebar");
            localStorage.setItem("theme", "light");
        });

        $(".dark-setting").on("click", function () {
            $("body").attr("data-theme", "dark-only").removeClass("light dark-sidebar").addClass("dark-only");
            localStorage.setItem("theme", "dark");
        });

        $(".mix-setting").on("click", function () {
            $("body").attr("data-theme", "dark-sidebar").removeClass("dark-only light").addClass("dark-sidebar");
            localStorage.setItem("theme", "mix");
        });

        // ========================================
        // LTR / RTL / Box Layout
        // ========================================
        // $(".ltr-setting input").on("change", function () {
        //     if (this.checked) {
        //         $("body").removeClass("rtl box-layout dark-only");
        //         $("html").attr("dir", "ltr");
        //         localStorage.setItem("dir", "ltr");
        //     }
        // });

        $(".rtl-setting input").on("change", function () {
            if (this.checked) {
                $("body").removeClass("ltr box-layout dark-only");
                $("html").attr("dir", "rtl");
                localStorage.setItem("dir", "rtl");
            }
        });

        $(".box-setting input").on("change", function () {
            if (this.checked) {
                $("body").addClass("box-layout").removeClass("rtl ltr");
                $("html").removeAttr("dir");
                localStorage.setItem("layout", "box");
            }
        });

        // ========================================
        // Sidebar Icon (Stroke vs Colorful)
        // ========================================
        $("input[name='sidebarIcon']").on("change", function () {
            if ($(this).val() === "colorful") {
                $(".page-sidebar").addClass("iconcolor-sidebar").attr("data-sidebar-layout", "iconcolor-sidebar");
            } else {
                $(".page-sidebar").removeClass("iconcolor-sidebar").attr("data-sidebar-layout", "stroke-svg");
            }
        });

        // ========================================
        // Vertical / Horizontal Sidebar
        // ========================================
        $("input[name='sidebarType']").on("change", function () {
            if ($(this).val() === "horizontal") {
                $(".page-wrapper").removeClass("compact-wrapper").addClass("horizontal-sidebar");
            } else {
                $(".page-wrapper").removeClass("horizontal-sidebar").addClass("compact-wrapper");
            }
            // تحديث عند تغيير حجم الشاشة
            $(window).trigger("resize");
        });

        // ========================================
        // Horizontal Sidebar Arrows (إن وُجدت)
        // ========================================
        const $mainSidebar = $("#main-sidebar");
        const move = 500;
        let sliderLimit = -3250;

        function updateSliderLimit() {
            const width = $(".page-sidebar").innerWidth();
            sliderLimit = width >= 1660 ? -3250 : -4500;
        }

        $("#right-arrow").on("click", function () {
            updateSliderLimit();
            const current = parseInt($mainSidebar.css("marginLeft"));
            if (current >= sliderLimit) {
                $mainSidebar.stop().animate({ marginLeft: "-=" + move }, 400);
                $("#left-arrow").removeClass("disabled");
                if (parseInt($mainSidebar.css("marginLeft")) <= sliderLimit + move) {
                    $(this).addClass("disabled");
                }
            }
        });

        $("#left-arrow").on("click", function () {
            const current = parseInt($mainSidebar.css("marginLeft"));
            if (current < 0) {
                $mainSidebar.stop().animate({ marginLeft: "+=" + move }, 400);
                $("#right-arrow").removeClass("disabled");
                if (parseInt($mainSidebar.css("marginLeft")) >= 0) {
                    $(this).addClass("disabled");
                }
            }
        });

    });

})(jQuery);
