<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
    <a href="<?= $router->route('admin.index') ?>">
        <span class="menu-link <?= activeMenu(['admin', '/'], $page); ?>">
            <span class="menu-icon">
                <span class="svg-icon svg-icon-2">
                    <i class="las la-home"></i>
                </span>
            </span>
            <span class="menu-title">Dashboard</span>
        </span>
    </a>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link <?= activeMenu('categorie', $page); ?>">
        <span class="menu-icon">
            <span class="svg-icon svg-icon-2">
                <i class="las la-clipboard-list"></i>
            </span>
        </span>
        <span class="menu-title">Categorias</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="<?= $router->route('categorie.list') ?>">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Listar</span>
            </a>
            <a class="menu-link" href="<?= $router->route('categorie.new') ?>">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Novo</span>
            </a>
        </div>
    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link <?= activeMenu('courses', $page); ?>">
        <span class="menu-icon">
            <span class="svg-icon svg-icon-2">
                <i class="las la-film"></i>
            </span>
        </span>
        <span class="menu-title">Cursos</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="<?= $router->route('courses.list') ?>">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Listar</span>
            </a>
            <a class="menu-link" href="<?= $router->route('courses.new') ?>">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Novo</span>
            </a>
        </div>
    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link <?= activeMenu('trail', $page); ?>">
        <span class="menu-icon">
            <span class="svg-icon svg-icon-2">
                <i class="las la-list"></i>
            </span>
        </span>
        <span class="menu-title">Trilha</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="<?= $router->route('trail.list') ?>">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Listar</span>
            </a>
            <a class="menu-link" href="<?= $router->route('trail.new') ?>">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Novo</span>
            </a>
        </div>
    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <a href="<?= $router->route('users.list') ?>">
        <span class="menu-link <?= activeMenu('users', $page); ?>">
            <span class="menu-icon">
                <span class="svg-icon svg-icon-2">
                    <i class="las la-users"></i>
                </span>
            </span>
            <span class="menu-title">Usuários</span>
        </span>
    </a>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link <?= activeMenu('reports', $page); ?>">
        <span class="menu-icon">
            <span class="svg-icon svg-icon-2">
                <i class="las la-torah"></i>
            </span>
        </span>
        <span class="menu-title">Relatórios</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion">
        <div class="menu-item">
            <a class="menu-link" href="<?= $router->route('reports.accessLogs') ?>">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Logs de Acesso</span>
            </a>
            <a class="menu-link" href="<?= $router->route('reports.performanceCourse') ?>">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Performance Curso</span>
            </a>
            <a class="menu-link" href="<?= $router->route('reports.performanceTrail') ?>">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Performance Trilha</span>
            </a>
        </div>
    </div>
</div>
