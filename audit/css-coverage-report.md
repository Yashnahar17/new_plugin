# Astrax Addons — CSS Coverage Report

Generated during Phase 1 Comprehensive Codebase Audit.

## Category Coverage Summary

| Category | Total Widgets | Complete CSS | Partial CSS | Missing CSS |
|---|---|---|---|---|
| **ACF** | 9 | 0 | 0 | 9 |
| **AI** | 13 | 0 | 0 | 13 |
| **Animation** | 18 | 0 | 0 | 18 |
| **Blog** | 25 | 0 | 0 | 25 |
| **Business** | 20 | 0 | 1 | 19 |
| **Content** | 21 | 0 | 5 | 16 |
| **Creative** | 32 | 0 | 1 | 31 |
| **Data** | 11 | 1 | 0 | 10 |
| **DataViz** | 15 | 0 | 0 | 15 |
| **Developer** | 11 | 0 | 2 | 9 |
| **Dynamic** | 20 | 0 | 1 | 19 |
| **FAQ** | 10 | 0 | 0 | 10 |
| **Forms** | 17 | 0 | 0 | 17 |
| **Images** | 18 | 2 | 1 | 15 |
| **Interactive** | 20 | 1 | 1 | 18 |
| **Marketing** | 19 | 0 | 0 | 19 |
| **Media** | 14 | 0 | 0 | 14 |
| **Navigation** | 14 | 1 | 0 | 13 |
| **Root** | 9 | 1 | 3 | 5 |
| **Social** | 13 | 0 | 0 | 13 |
| **Team** | 11 | 0 | 1 | 10 |
| **Testimonials** | 12 | 0 | 0 | 12 |
| **Typography** | 14 | 0 | 1 | 13 |
| **User** | 11 | 0 | 0 | 11 |
| **Woo** | 31 | 0 | 0 | 31 |
| **TOTAL** | **408** | **6** | **17** | **385** |

## Key Findings

1. **Core Flagship Widgets** (`ImageAccordion`, `AdvancedHeading`, `AdvancedButton`, `InfoBox`, `IconBox`, `PostGrid`) have dedicated CSS definitions in `v3-widgets.css` and `image-accordion.css`.
2. **Category Scaffolds**: The remaining scaffolded widgets rely primarily on inline elementor style generation. Default stylesheet rules are missing in `v3-widgets.css`.
3. **Asset Registration Gaps**: `AssetManager.php` registers handles for stylesheets (`tabs.css`, `woo-carousel.css`, `gallery.css`, `bento.css`) that do not yet exist on disk.
