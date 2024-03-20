
/* {{nameUpper}} */
$router->group("{{nameLower}}")->namespace("App\Controllers\{{themeUcfirst}}");
$router->get("/", "{{name}}:list", "{{nameLc}}.list");
$router->get("/novo", "{{name}}:new", "{{nameLc}}.new");
$router->get("/editar/{id}", "{{name}}:edit", "{{nameLc}}.edit");
$router->post("/", "{{name}}:post", "{{nameLc}}.post");
$router->put("/", "{{name}}:put", "{{nameLc}}.put");
$router->delete("/{id}", "{{name}}:delete", "{{nameLc}}.delete");