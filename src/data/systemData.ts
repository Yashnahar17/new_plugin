export interface SystemStatus {
  php_version: string;
  wp_version: string;
  elementor_version: string;
  elementor_pro_version: string;
  server_software: string;
  memory_limit: string;
  max_execution_time: string;
  active_widgets: number;
  total_widgets: number;
  active_extensions: number;
  total_extensions: number;
  rest_api_active: boolean;
  rest_namespace: string;
  asset_optimization: string;
  phpstan_level: string;
  compliance_status: string;
}

export const INITIAL_SYSTEM_INFO: SystemStatus = {
  php_version: '8.2.18 (Compatible with PHP 7.4 - 8.3)',
  wp_version: '6.6.2 (Compatible with WP 6.0+)',
  elementor_version: '3.24.4 (Tested up to 3.24)',
  elementor_pro_version: '3.24.2 (Tested up to 3.24)',
  server_software: 'Linux / Node.js 22 Runtime',
  memory_limit: '512 MB (Recommended: 256 MB+)',
  max_execution_time: '300s',
  active_widgets: 48,
  total_widgets: 55,
  active_extensions: 4,
  total_extensions: 4,
  rest_api_active: true,
  rest_namespace: 'astrax-addons/v1',
  asset_optimization: 'Dynamic Selective Asset Loading Enabled',
  phpstan_level: 'Level 8 Clean',
  compliance_status: 'WordPress Coding Standards (WPCS 3.0) & GPL v2+'
};

export const COMPATIBILITY_MATRIX = [
  { component: 'WordPress Core', required: '>= 6.0', current: '6.6.2', status: 'Passed' },
  { component: 'Elementor Core', required: '>= 3.16', current: '3.24.4', status: 'Passed' },
  { component: 'Elementor Pro (Optional)', required: '>= 3.16', current: '3.24.2', status: 'Passed' },
  { component: 'WooCommerce (Optional)', required: '>= 8.0', current: '9.2.1', status: 'Passed' },
  { component: 'PHP Runtime', required: '>= 7.4', current: '8.2.18', status: 'Passed' },
  { component: 'MySQL / MariaDB', required: '>= 5.7 / 10.4', current: '10.11.6', status: 'Passed' },
  { component: 'REST API Nonce Verification', required: 'wp_rest nonce', current: 'Active', status: 'Secure' },
  { component: 'Escaping / XSS Sanitization', required: 'wp_kses / esc_html', current: '100% Audited', status: 'Secure' }
];
