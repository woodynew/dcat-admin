# Changelog

## 2.2.4

- Extend the maintained fork compatibility surface through Laravel 12 while preserving the existing `Dcat\Admin\` public namespace.
- Harden PHP 8.x compatibility across Grid, Form, Show, widgets, generators and extension lifecycle code.
- Support both Flysystem 1 and Flysystem 3 resource publishing paths.
- Restrict extension installation to trusted local archives and reject unsafe package names and ZIP traversal entries.
- Escape extension metadata and tolerate optional Composer author fields.
- Fix extension version history, command failures, modal rendering and lazy-renderable compatibility.
- Replace the legacy CI workflow with Laravel 8–12 compatibility jobs and representative Laravel 8/12 Dusk jobs.
- Rewrite the fork README while preserving upstream attribution and the MIT license.
