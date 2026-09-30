#!/usr/bin/env python3
"""
Astrax Addons — Release Packaging Script (Phase 19)
Creates a clean, production-grade WordPress plugin ZIP distribution.
Excludes developer tooling, test suites, and internal scripts.
"""

import os
import zipfile
import shutil

SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
PLUGIN_DIR = os.path.dirname(SCRIPT_DIR)
ROOT_DIR = os.path.dirname(PLUGIN_DIR)
DIST_DIR = os.path.join(ROOT_DIR, 'dist')
ZIP_NAME = 'astrax-addons-production-v1.0.0.zip'
ZIP_PATH = os.path.join(DIST_DIR, ZIP_NAME)

os.makedirs(DIST_DIR, exist_ok=True)

# Files and directories to strictly exclude from production distribution
EXCLUDE_DIRS = {
    'tests',
    '.github',
    'scripts',
    'node_modules',
    'astrax_audit_and_variants_tools',
    '.git',
    'vendor'
}

EXCLUDE_FILES = {
    'composer.json',
    'composer.lock',
    '.eslintrc.json',
    '.stylelintrc.json',
    '.prettierrc',
    '.gitignore',
    'astrax_audit_and_variants_tools.zip',
    'phpunit.xml.dist',
    'phpstan.neon.dist',
    'phpcs.xml.dist'
}

print(f"Building production distribution: {ZIP_NAME}...")

file_count = 0
total_uncompressed_bytes = 0

with zipfile.ZipFile(ZIP_PATH, 'w', zipfile.ZIP_DEFLATED) as zipf:
    for root, dirs, files in os.walk(PLUGIN_DIR):
        # Exclude directories
        dirs[:] = [d for d in dirs if d not in EXCLUDE_DIRS]

        for file in files:
            if file in EXCLUDE_FILES or file.endswith('.zip') or file.startswith('.'):
                continue

            abs_file = os.path.join(root, file)
            rel_file = os.path.relpath(abs_file, PLUGIN_DIR)
            zip_entry = os.path.join('astrax-addons', rel_file)

            file_size = os.path.getsize(abs_file)
            total_uncompressed_bytes += file_size
            file_count += 1

            zipf.write(abs_file, zip_entry)

zip_size = os.path.getsize(ZIP_PATH)
print(f"✅ Production package successfully created at: {ZIP_PATH}")
print(f"   Files packaged:       {file_count}")
print(f"   Uncompressed size:    {total_uncompressed_bytes / 1024:.1f} KB")
print(f"   Compressed ZIP size:  {zip_size / 1024:.1f} KB")
