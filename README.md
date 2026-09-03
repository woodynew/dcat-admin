# woodynew/dcat-laravel-admin

[![Packagist](https://img.shields.io/packagist/v/woodynew/dcat-laravel-admin?include_prereleases)](https://packagist.org/packages/woodynew/dcat-laravel-admin)
[![PHP](https://img.shields.io/badge/PHP-%3E%3D7.1-777bb4)](composer.json)
[![Laravel](https://img.shields.io/badge/Laravel-5.5--12.x-ff2d20)](composer.json)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

> 本项目是 [jqhph/dcat-admin](https://github.com/jqhph/dcat-admin) `2.0` 分支的维护型 fork。原项目由 Jiang qinghua、Jens Segers 及社区贡献者开发，本 fork 保留原 MIT License、原项目出处和贡献者归属。

`woodynew/dcat-laravel-admin` 面向仍在使用 Dcat Admin 2.x 的 Laravel 项目，维护基础框架兼容性、通用缺陷与安全修复。它不是一个全新后台框架，也不替代上游历史文档。

本仓库负责维护 Dcat Admin 基座能力、兼容性和通用缺陷修复。面向具体项目的后台组件、交互约定和业务扩展，应放入独立的 [`woodynew/dcat-admin-kit`](https://github.com/woodynew/dcat-admin-kit)；Controller、Service、Model、业务路由和业务数据继续留在各应用项目中。

## 核心能力

- 后台用户、角色、权限、菜单和无限层级 RBAC。
- `Grid` 数据表格：筛选、排序、分页、组合表头、行操作、批量操作、导出和异步加载。
- `Form` 数据表单：丰富字段、校验、异步提交、弹窗表单、分步表单和关联数据。
- `Show` 数据详情和 `Tree` 树形数据管理、拖拽排序。
- PJAX 无刷新页面和按需静态资源加载。
- 自定义页面、布局、Section、Navbar、主题颜色和暗色模式。
- 文件上传、分块上传、图片/文件字段与多存储驱动。
- Repository 数据访问抽象，可替换 Eloquent 数据源。
- 多后台应用、独立页面和 Laravel Octane 状态清理。
- CRUD、Form、Action 等 Artisan 代码生成命令。
- 插件扩展的注册、配置、路由、视图、语言、资源、菜单、启停、版本升级和回滚。

## 本 fork 的维护增强

- Composer 包名调整为 `woodynew/dcat-laravel-admin`，保持 `Dcat\Admin\` 公共命名空间兼容。
- 合并上游 `2.0` 最新代码，并保留 Grid Modal 重复渲染、固定列高度与选择器修复。
- Composer 声明兼容 Laravel 10、11、12，同时保留 Laravel 5.5～9 的依赖范围。
- 修复 PHP 8.4 隐式 nullable 弃用，并保持 PHP 7.4 语法兼容。
- 同时兼容 Flysystem 1 和 Flysystem 3 的资源发布流程。
- 加固插件 ZIP 安装：仅允许可信本地包，阻止路径穿越和非法包名目录逃逸。
- 加固插件元数据输出，限制外链协议并转义作者、主页和 Logo 属性。
- 修复插件版本增量计算、重复卸载和命令退出码。
- 修复只实现 `LazyRenderable` 契约但未提供 `payload()` 时的致命调用。
- 修正测试 PSR-4、PHPUnit 11 元数据弃用和遗留测试凭据。

## 项目定位

```text
jqhph/dcat-admin（上游）
        ↓ 同步和筛选上游变更
woodynew/dcat-laravel-admin（本仓库：基础框架 fork）
        ↓ Composer 依赖
woodynew/dcat-admin-kit（通用扩展能力）
        ↓ Composer 依赖
具体 Laravel 业务项目
```

本仓库应该包含：

- Dcat Admin 核心 API 与运行时。
- Laravel、PHP 和 Composer 兼容性维护。
- Grid、Form、Show、Tree 等基础构建能力。
- 后台认证、权限、菜单、布局和资源管理。
- 插件/扩展生命周期与脚手架。
- 可复用且不带项目语义的框架级缺陷修复。

本仓库不应该包含：

- 具体项目的 Controller、Service、Repository、Model。
- 项目专属菜单、数据库表、登录主题和品牌资源。
- 依赖某个应用 `App\...` 命名空间的组件。
- 趣拉新等业务项目的通用扩展；这些能力应进入独立 Kit。

## 当前基线

| 项目 | 当前状态 |
| --- | --- |
| 维护分支 | `2.0` |
| 当前版本 | `2.2.4` |
| Composer 包名 | `woodynew/dcat-laravel-admin` |
| PHP 约束 | `>= 7.1` |
| Laravel 声明约束 | `5.5`～`12.x` |
| PHP 命名空间 | `Dcat\Admin\` |
| Laravel 自动发现入口 | `Dcat\Admin\AdminServiceProvider` |
| 当前语法验证 | PHP 7.4、PHP 8.4 |
| 当前定向运行验证 | Laravel 8 / Flysystem 1、Laravel 12 / Flysystem 3 |
| CI 兼容矩阵 | Laravel 8～12；Dusk 覆盖 Laravel 8、12 |
| License | MIT |

> Laravel 5.5～12.x 是 Composer 声明范围，不等于全部组合均完成运行验收。当前 CI 将 Laravel 8～12 作为发布兼容矩阵；Laravel 5.5～7 属于遗留兼容范围，不作为本 fork 当前稳定版本的自动化发布门禁。

## 目录结构

```text
.
├── .github/                 # GitHub Actions 和仓库自动化配置
├── config/                  # 发布到接入项目的 Dcat Admin 配置
├── database/
│   └── migrations/          # 管理员、权限、菜单、设置、插件等基础表迁移
├── docs/                    # 仓库辅助文档，目前主要是 Issue 模板
├── fonts/                   # 历史遗留字体文件，后续需要确认是否仍被使用
├── resources/
│   ├── assets/              # 前端源文件：AdminLTE、Dcat JS/Sass、字体、图片、第三方插件
│   ├── dist/                # 已构建资源；安装时发布到接入项目 public 目录
│   ├── lang/                # 英文、简体中文、繁体中文语言包
│   └── views/               # Grid、Form、Show、Tree、布局和组件 Blade 视图
├── src/                     # Dcat Admin PHP 核心源码
├── tests/                   # Feature、Browser/Dusk、测试模型和测试应用资源
├── composer.json            # PHP 包定义、依赖、自动加载与 Laravel Provider
├── package.json             # 前端构建依赖和 npm scripts
├── phpunit.dusk.xml         # Dusk 浏览器测试配置
└── webpack.mix.js           # Laravel Mix 资源构建入口
```

## `src/` 核心模块

| 路径 | 主要职责 |
| --- | --- |
| `src/AdminServiceProvider.php` | Laravel 包入口；注册服务、命令、中间件、发布项和插件生命周期 |
| `src/Admin.php` | Dcat 全局访问入口，提供应用、资源、菜单、插件、响应等静态门面能力 |
| `src/Application.php` | 后台应用启动、路由装载、多应用切换和应用级配置 |
| `src/Grid.php`、`src/Grid/` | 数据表格、筛选、列展示、行操作、批量操作、导出和分页 |
| `src/Form.php`、`src/Form/` | 表单字段、校验、创建/更新/删除流程、弹窗与异步表单 |
| `src/Show.php`、`src/Show/` | 数据详情展示、字段扩展和关联数据展示 |
| `src/Tree.php`、`src/Tree/` | 树形数据展示、拖拽排序、层级维护和树操作 |
| `src/Actions/` | 通用动作、动作响应和异步动作基础设施 |
| `src/Console/` | 安装、发布、代码生成、插件管理、升级等 Artisan 命令 |
| `src/Contracts/` | Repository、Tree、上传字段、异常处理等公开契约 |
| `src/Exception/` | Dcat 运行时异常和异常处理器 |
| `src/Extend/` | 插件发现、注册、启停、配置、资源发布、版本升级与回滚 |
| `src/Http/` | Dcat 内置 Controller、Middleware、Action、Form、Displayer 和 Repository |
| `src/Layout/` | 页面布局、资源、菜单、导航栏、Section 和 Content |
| `src/Models/` | 管理员、角色、权限、菜单、设置和插件记录等内置模型 |
| `src/Octane/` | Laravel Octane 场景下的状态清理与生命周期适配 |
| `src/Repositories/` | 数据访问抽象及 Eloquent Repository 实现 |
| `src/Scaffold/` | 后台 CRUD 等代码生成器及模板 |
| `src/Support/` | Composer、配置、上下文、上传、翻译等基础工具 |
| `src/Traits/` | 多个模块共享的行为复用 |
| `src/Widgets/` | 表格、卡片、图表、统计指标等后台组件 |
| `src/Color.php` | 主题颜色、颜色扩展及明暗计算 |

Grid 和 Form 是目前最大的两个模块，也是改动风险最高的区域。调整这两个目录时，需要同时验证同步页面、PJAX/异步请求、弹窗表单和前端资源行为。

## 启动流程

Laravel 通过 Composer 自动发现 `Dcat\Admin\AdminServiceProvider`，主要启动顺序如下：

1. `register()` 注册后台应用、资源、菜单、插件管理器、中间件和 Artisan 命令。
2. `Admin::extension()->register()` 发现并注册插件。
3. `boot()` 注册默认 Section、视图、HTTPS、后台应用路由和资源发布项。
4. `Admin::extension()->boot()` 启动已启用插件。
5. 接入项目通过 `config/admin.php`、`app/Admin/routes.php` 和 `app/Admin/bootstrap.php` 完成应用级定制。

核心资源发布映射：

```text
config/                 → 接入项目 config/
database/migrations/    → 接入项目 database/migrations/
resources/lang/         → 接入项目 resources/lang/
resources/dist/         → 接入项目 public/vendor/dcat-admin/
```

## 插件系统

插件核心实现位于 `src/Extend/`，管理页面和操作位于 `src/Http/Controllers/ExtensionController.php` 及 `src/Http/Actions/Extensions/`。

当前已经实现：

- `admin:ext-make` 生成插件或主题脚手架。
- 从 `dcat-admin-extensions/{vendor}/{name}` 发现本地插件。
- 根据插件 `composer.json` 的 `extra.dcat-admin` 注册 ServiceProvider。
- 自动装载插件路由、视图、语言包、中间件和静态资源。
- 插件设置表单和设置持久化。
- 插件菜单添加、刷新和卸载清理。
- `version.php` 和 `updates/` 驱动的安装、更新与回滚。
- 后台及命令行启用、禁用、更新、回滚和卸载。
- 本地 ZIP 插件安装。

当前维护边界：

- 在线插件市场入口已禁用，`admin:ext-install` 必须通过 `--path` 指定可信本地 ZIP。
- 插件包签名、来源信任和完整性校验不完善。

因此，生产环境应使用 Composer/Packagist 分发插件代码；Dcat 插件机制只负责运行时注册、配置、资源、菜单和启停管理。不要在生产后台开放任意 ZIP 插件上传能力。

## 前端资源

前端源文件位于 `resources/assets/`，构建结果位于 `resources/dist/`。`AdminServiceProvider` 发布的是 `resources/dist/`，因此修改源文件后必须重新构建并检查构建产物。

```bash
npm install
npm run dev
npm run prod
```

当前构建链基于 Laravel Mix 4、Webpack 4 和较旧的 Node 生态。升级 Node 或前端依赖前，应先固定可工作的 Node 版本并补充资源构建验证，不要直接批量升级。

## PHP 开发与验证

安装依赖：

```bash
composer install
```

当前可靠的基础验证：

```bash
composer validate --strict --no-check-publish
php74 -l path/to/file.php
php84 -d error_reporting=E_ALL -l path/to/file.php
vendor/bin/phpunit -c phpunit.compatibility.xml
```

GitHub Actions 会在全新的 Laravel 8～12 项目中安装当前 fork，验证资源发布、数据库安装与回滚、兼容性 Feature 测试、包发现、路由和配置缓存。Dusk 浏览器测试选择 Laravel 8 与 12 两端版本，并自动匹配 GitHub Runner 的 ChromeDriver；失败时保留服务日志、浏览器控制台和截图。

`composer phpstan` 当前仍是遗留代码审计工具，CI 以 advisory Job 持续展示结果但不阻断合并：level 0 尚有历史问题，不能通过 baseline 静默忽略，应按模块逐步收敛。

## 在 Laravel 项目中安装

安装稳定版本：

```bash
composer require woodynew/dcat-laravel-admin:^2.2.4
php artisan admin:publish
php artisan admin:install
```

`admin:install` 会执行数据库迁移和初始化后台数据，只应在确认数据库连接和目标环境后运行。已有 Dcat 项目升级时不要重复执行安装命令，应按版本说明单独处理升级。

## Fork 维护边界

后续维护遵循以下原则：

1. 保持 `Dcat\Admin\` 公共 API 和现有项目兼容。
2. 上游变更先评估再同步，不无条件合并。
3. 框架缺陷、兼容性和安全修复进入本仓库。
4. 项目通用扩展进入独立 `dcat-admin-kit`。
5. 业务代码和业务数据变更留在业务项目。
6. PHP/Laravel 大版本兼容通过独立版本线和 CI 矩阵证明。
7. 发布前至少执行 Composer 校验、自动化测试、静态分析和资源构建验证。

## 上游与开源归属

- 原项目：[jqhph/dcat-admin](https://github.com/jqhph/dcat-admin)
- 原项目作者与版权：Jiang qinghua、Jens Segers，详见仓库 [LICENSE](LICENSE)。
- 原项目贡献者：[jqhph/dcat-admin contributors](https://github.com/jqhph/dcat-admin/graphs/contributors)
- 原项目基于：[z-song/laravel-admin](https://github.com/z-song/laravel-admin)
- 历史中文文档：[Dcat Admin 文档](https://learnku.com/docs/dcat-admin)
- Laravel 文档：[laravel.com/docs](https://laravel.com/docs)

本 fork 的修改继续按 MIT License 分发。复制、修改或再分发本项目时，必须保留 [LICENSE](LICENSE) 中的原版权声明和许可文本。

主要开源依赖及前端基础包括 Laravel、Laravel Admin、AdminLTE、Bootstrap、jQuery、Flysystem、Font Awesome、PJAX、WebUploader、Layer、Toastr、NProgress、Moment、Chart.js 等；各组件分别遵循其自身许可证。

## License

本项目沿用原 Dcat Admin 的 [MIT License](LICENSE)，保留原版权声明；本 fork 新增修改亦按 MIT License 提供。
