<!DOCTYPE html>
<html lang="pt-BR" style="overflow: hidden">
    <head>
        <?= $this->insert("$theme::partials/head") ?>
        <?= $this->insert("$theme::partials/constants") ?>
    </head>
    <body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
          data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
          data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
          data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
        <?= $gtmBody; ?>
        <?= $this->insert("$theme::partials/loader"); ?>
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
              <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
                <?= $this->insert("$theme::partials/header") ?>
                <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                    <?= $this->insert("$theme::partials/sidebar") ?>
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <?= $this->section("content"); ?>
                        </div>
                        <?= $this->insert("$theme::partials/footer") ?>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->insert("$theme::partials/scripts") ?>
        <?= $this->section("scripts"); ?>
    </body>
</html>