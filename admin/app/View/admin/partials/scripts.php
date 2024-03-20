<script>
    var defaultThemeMode = "dark";
    var themeMode;

    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-theme-mode");
        } else {
            themeMode = localStorage.getItem("data-theme");
            if (!themeMode) {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-theme", themeMode);
        localStorage.setItem("data-theme", themeMode);
    }
</script>

<!--THEME-->
<script type="text/javascript" src="<?= asset("common", "js/plugins.bundle.js"); ?>"></script>
<script type="text/javascript" src="<?= asset("common", "js/scripts.bundle.js"); ?>"></script>

<script type="text/javascript" src="<?= asset("common", "js/common.min.js"); ?>"></script>

<script type="text/javascript" src="<?= asset($theme, "js/{$theme}.min.js"); ?>"></script>

<!--PAGE SCRIPT-->
<?= (!empty($jsFile)) ? '<script type="text/javascript" src="' . asset($theme, "js/pages/{$jsFile}") . '"></script>' : ""; ?>