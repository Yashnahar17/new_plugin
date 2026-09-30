# Astrax Addons — Security Audit Report

Total potential unescaped output sites detected: **4**

| Widget | File | Finding |
|---|---|---|
| `Gallery` | `includes/Widgets/Images/Gallery.php` | Direct unescaped variable output detected in render() |
| `PlannedGalleryWidget` | `includes/Widgets/Images/PlannedGalleryWidget.php` | Direct unescaped variable output detected in render() |
| `PlannedImageEffectWidget` | `includes/Widgets/Images/PlannedImageEffectWidget.php` | Direct unescaped variable output detected in render() |
| `TextRotator` | `includes/Widgets/Typography/TextRotator.php` | Direct unescaped variable output detected in render() |

### REST API & Admin Security Audit
- REST routes in `RestManager.php` enforce permission callbacks checking `current_user_can('manage_options')`.
- State-changing POST requests validate WordPress nonces via `wp_verify_nonce`.
- Direct PHP file execution is guarded by `if ( ! defined( 'ABSPATH' ) ) { exit; }` across all files.
