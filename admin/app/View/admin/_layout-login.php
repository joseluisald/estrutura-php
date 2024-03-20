<!DOCTYPE html>
<html lang="pt-BR" style="overflow: hidden">
    <head>
        <?= $this->insert("$theme::partials/head") ?>
        <?= $this->insert("$theme::partials/constants") ?>
    </head>
    <body id="kt_body" class="app-blank app-blank">

        <?= $this->insert("$theme::partials/loader"); ?>

        <?= $this->section("content"); ?>

        <?= $this->insert("$theme::partials/scripts") ?>
        <?= $this->section("scripts"); ?>
    </body>
</html>