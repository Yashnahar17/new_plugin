#!/usr/bin/env bash
set -e

# ==============================================================================
# Astrax Addons — Automated Widget CSS Audit Script (Section 55)
# Extracts classes from render methods, Elementor selector definitions,
# verifies CSS selectors in stylesheets, and generates audit reports.
# ==============================================================================

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "${SCRIPT_DIR}/.." && pwd)"

mkdir -p "${ROOT_DIR}/audit/css"

node "${SCRIPT_DIR}/run-css-audit.cjs"

echo "CSS Audit successfully generated in audit/css/:"
ls -lh "${ROOT_DIR}/audit/css/"
