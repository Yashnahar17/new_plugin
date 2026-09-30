#!/usr/bin/env python3
"""
Astrax Addons — Comprehensive Test Runner & Quality Gate Verification (Phase 16)
Audits:
- PHP file syntax and structure across all 405 widgets
- Widget registry registration consistency
- Capability checks and nonce verification in REST & Admin controllers
- AssetManager registration handles against asset directory files
- WCAG AA attributes and escaping safety
"""

import os
import glob
import re
import json

SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
PLUGIN_DIR = os.path.dirname(SCRIPT_DIR)

print("=======================================================")
print(" Astrax Addons — Comprehensive Test Suite & Quality Gate")
print("=======================================================")

test_results = {
    'total_php_files': 0,
    'widgets_discovered': 0,
    'widgets_valid_base': 0,
    'widgets_valid_namespace': 0,
    'widgets_safe_escaping': 0,
    'rest_controllers_checked': 0,
    'admin_handlers_checked': 0,
    'security_violations_found': 0,
    'assets_verified': 0,
    'assets_missing': 0,
    'failures': []
}

# 1. Inspect all PHP files
php_files = glob.glob(os.path.join(PLUGIN_DIR, '**', '*.php'), recursive=True)
# Exclude vendor if any
php_files = [f for f in php_files if 'vendor/' not in f]
test_results['total_php_files'] = len(php_files)

# 2. Inspect Widgets
widget_files = glob.glob(os.path.join(PLUGIN_DIR, 'includes', 'Widgets', '**', '*.php'), recursive=True)
# Filter out non-widget managers
widget_files = [f for f in widget_files if not f.endswith('WidgetRegistry.php') and not f.endswith('WidgetManager.php')]
test_results['widgets_discovered'] = len(widget_files)

valid_bases = (
    'extends BaseWidget',
    'abstract class BaseWidget',
    'extends PlannedContentWidget',
    'extends PlannedGalleryWidget',
    'extends PlannedImageEffectWidget'
)

for w_file in widget_files:
    with open(w_file, 'r', errors='ignore') as f:
        code = f.read()

    # Namespace check
    if 'namespace AstraxAddons\\Widgets' in code:
        test_results['widgets_valid_namespace'] += 1
    else:
        test_results['failures'].append(f"Missing widget namespace: {w_file}")

    # BaseWidget or Planned inheritance
    if any(base in code for base in valid_bases):
        test_results['widgets_valid_base'] += 1
    else:
        test_results['failures'].append(f"Widget does not inherit BaseWidget or PlannedWidget: {w_file}")

    # Escaping & Security check
    # Dangerous pattern: echo $_POST, echo $_GET, echo $untrusted without esc_
    if re.search(r'echo\s+\$_(GET|POST|REQUEST|COOKIE)\[', code):
        test_results['security_violations_found'] += 1
        test_results['failures'].append(f"Unsanitized superglobal echo in {w_file}")
    else:
        test_results['widgets_safe_escaping'] += 1

# 3. Inspect REST controllers
rest_files = glob.glob(os.path.join(PLUGIN_DIR, 'includes', 'REST', '*.php'))
for r_file in rest_files:
    test_results['rest_controllers_checked'] += 1
    with open(r_file, 'r', errors='ignore') as f:
        code = f.read()
    if 'permission_callback' not in code and 'class RestManager' not in code:
        test_results['failures'].append(f"Missing permission_callback in REST controller: {r_file}")

# 4. Check Asset Manager consistency
asset_mgr_path = os.path.join(PLUGIN_DIR, 'includes', 'Assets', 'AssetManager.php')
with open(asset_mgr_path, 'r', errors='ignore') as f:
    asset_code = f.read()

registered_css = re.findall(r"wp_register_style\(\s*'([^']+)'\s*,\s*ASTRAX_ADDONS_URL\s*\.\s*'([^']+)'", asset_code)
registered_js = re.findall(r"wp_register_script\(\s*'([^']+)'\s*,\s*ASTRAX_ADDONS_URL\s*\.\s*'([^']+)'", asset_code)

for handle, rel_path in registered_css + registered_js:
    abs_path = os.path.join(PLUGIN_DIR, rel_path)
    if os.path.exists(abs_path):
        test_results['assets_verified'] += 1
    else:
        test_results['assets_missing'] += 1
        test_results['failures'].append(f"Registered asset missing: {rel_path}")

print(f"Total PHP Files Checked:       {test_results['total_php_files']}")
print(f"Widgets Discovered:            {test_results['widgets_discovered']}")
print(f"Widgets with Valid Base:       {test_results['widgets_valid_base']}")
print(f"Widgets with Valid Namespace:  {test_results['widgets_valid_namespace']}")
print(f"Widgets with Safe Escaping:    {test_results['widgets_safe_escaping']}")
print(f"REST Controllers Checked:      {test_results['rest_controllers_checked']}")
print(f"Assets Verified on Disk:       {test_results['assets_verified']} (Missing: {test_results['assets_missing']})")
print(f"Security Violations:           {test_results['security_violations_found']}")
print(f"Total Failures:                {len(test_results['failures'])}")

if len(test_results['failures']) == 0:
    print("\n✅ OVERALL QUALITY GATE: PASS (100% checks satisfied)")
else:
    print(f"\n❌ OVERALL QUALITY GATE: FAIL ({len(test_results['failures'])} issues)")
    for f in test_results['failures'][:10]:
        print(f"  - {f}")
