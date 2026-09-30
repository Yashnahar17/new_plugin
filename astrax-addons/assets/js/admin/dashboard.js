const { render, useState, useEffect } = wp.element;
const { Panel, PanelBody, PanelRow, ToggleControl, TextControl, Button, Notice, Spinner } = wp.components;
const { __ } = wp.i18n;
const apiFetch = wp.apiFetch;

/**
 * Main App Component.
 */
function AstraxAdminDashboard() {
	const [activeTab, setActiveTab] = useState('widgets');
	const [widgets, setWidgets] = useState([]);
	const [extensions, setExtensions] = useState([]);
	const [settings, setSettings] = useState({ google_maps_api_key: '' });
	const [systemInfo, setSystemInfo] = useState(null);
	const [loading, setLoading] = useState(true);
	const [notices, setNotices] = useState([]);

	// Fetch initial data.
	useEffect(() => {
		apiFetch.use(apiFetch.createRootURLMiddleware(astraxAdminData.restUrl + '/'));
		apiFetch.use(apiFetch.createNonceMiddleware(astraxAdminData.nonce));

		Promise.all([
			apiFetch({ path: 'widgets' }),
			apiFetch({ path: 'extensions' }),
			apiFetch({ path: 'settings' }),
			apiFetch({ path: 'system' })
		]).then(([widgetsData, extensionsData, settingsData, systemData]) => {
			setWidgets(widgetsData);
			setExtensions(extensionsData);
			setSettings(settingsData);
			setSystemInfo(systemData);
			setLoading(false);
		}).catch(error => {
			addNotice('error', error.message || __('Failed to load data.', 'astrax-addons'));
			setLoading(false);
		});
	}, []);

	const addNotice = (status, content) => {
		const id = Date.now();
		setNotices(prev => [...prev, { id, status, content }]);
		setTimeout(() => {
			setNotices(prev => prev.filter(notice => notice.id !== id));
		}, 3000);
	};

	const toggleWidget = (slug, currentState) => {
		const newState = !currentState;
		// Optimistic update
		setWidgets(widgets.map(w => w.slug === slug ? { ...w, enabled: newState } : w));

		apiFetch({
			path: 'widgets/toggle',
			method: 'POST',
			data: { widget: slug, enabled: newState }
		}).then(res => {
			addNotice('success', res.message);
		}).catch(err => {
			// Revert on error
			setWidgets(widgets.map(w => w.slug === slug ? { ...w, enabled: currentState } : w));
			addNotice('error', err.message);
		});
	};

	const toggleExtension = (slug, currentState) => {
		const newState = !currentState;
		// Optimistic update
		setExtensions(extensions.map(e => e.slug === slug ? { ...e, enabled: newState } : e));

		apiFetch({
			path: 'extensions/toggle',
			method: 'POST',
			data: { extension: slug, enabled: newState }
		}).then(res => {
			addNotice('success', res.message);
		}).catch(err => {
			// Revert on error
			setExtensions(extensions.map(e => e.slug === slug ? { ...e, enabled: currentState } : e));
			addNotice('error', err.message);
		});
	};

	const saveSettings = () => {
		apiFetch({
			path: 'settings',
			method: 'POST',
			data: settings
		}).then(res => {
			addNotice('success', res.message);
		}).catch(err => {
			addNotice('error', err.message);
		});
	};

	if (loading) {
		return <div className="astrax-admin-loading"><Spinner /></div>;
	}

	return (
		<div className="astrax-admin-app">
			<div className="astrax-admin-header">
				<div style={{ display: 'flex', alignItems: 'center', gap: '15px', marginBottom: '10px' }}>
					<svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12 2L2 7L12 12L22 7L12 2Z" fill="white"/>
						<path d="M2 17L12 22L22 17" stroke="white" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
						<path d="M2 12L12 17L22 12" stroke="white" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/>
					</svg>
					<h1 style={{ margin: 0 }}>{__('Astrax Addons Dashboard', 'astrax-addons')}</h1>
				</div>
				<p>{__('Manage your widgets, extensions, and plugin settings.', 'astrax-addons')}</p>
			</div>

			<div className="astrax-admin-notices">
				{notices.map(notice => (
					<Notice key={notice.id} status={notice.status} isDismissible={false}>
						{notice.content}
					</Notice>
				))}
			</div>

			<div className="astrax-admin-nav">
				<button className={activeTab === 'widgets' ? 'active' : ''} onClick={() => setActiveTab('widgets')}>{__('Widgets', 'astrax-addons')}</button>
				<button className={activeTab === 'extensions' ? 'active' : ''} onClick={() => setActiveTab('extensions')}>{__('Extensions', 'astrax-addons')}</button>
				<button className={activeTab === 'settings' ? 'active' : ''} onClick={() => setActiveTab('settings')}>{__('Settings', 'astrax-addons')}</button>
				<button className={activeTab === 'system' ? 'active' : ''} onClick={() => setActiveTab('system')}>{__('System Info', 'astrax-addons')}</button>
			</div>

			<div className="astrax-admin-content">
				{activeTab === 'widgets' && (
					<Panel>
						<PanelBody title={__('Manage Widgets', 'astrax-addons')} initialOpen={true}>
							<p>{__('Enable or disable specific widgets to improve editor performance.', 'astrax-addons')}</p>
							{widgets.map(widget => (
								<PanelRow key={widget.slug}>
									<ToggleControl
										label={widget.name}
										checked={widget.enabled}
										onChange={() => toggleWidget(widget.slug, widget.enabled)}
									/>
								</PanelRow>
							))}
						</PanelBody>
					</Panel>
				)}

				{activeTab === 'extensions' && (
					<Panel>
						<PanelBody title={__('Manage Extensions', 'astrax-addons')} initialOpen={true}>
							<p>{__('Enable or disable cross-cutting extensions available on the Advanced tab.', 'astrax-addons')}</p>
							{extensions.map(ext => (
								<PanelRow key={ext.slug}>
									<ToggleControl
										label={ext.name}
										checked={ext.enabled}
										onChange={() => toggleExtension(ext.slug, ext.enabled)}
									/>
								</PanelRow>
							))}
						</PanelBody>
					</Panel>
				)}

				{activeTab === 'settings' && (
					<Panel>
						<PanelBody title={__('Global Settings', 'astrax-addons')} initialOpen={true}>
							<TextControl
								label={__('Google Maps API Key', 'astrax-addons')}
								value={settings.google_maps_api_key}
								onChange={val => setSettings({ ...settings, google_maps_api_key: val })}
								help={__('Required for the Google Maps widget.', 'astrax-addons')}
							/>
							<Button isPrimary onClick={saveSettings}>{__('Save Settings', 'astrax-addons')}</Button>
						</PanelBody>
					</Panel>
				)}

				{activeTab === 'system' && systemInfo && (
					<Panel>
						<PanelBody title={__('System Information', 'astrax-addons')} initialOpen={true}>
							<table className="widefat striped">
								<tbody>
									<tr>
										<td><strong>{__('PHP Version', 'astrax-addons')}</strong></td>
										<td>{systemInfo.php_version}</td>
									</tr>
									<tr>
										<td><strong>{__('WordPress Version', 'astrax-addons')}</strong></td>
										<td>{systemInfo.wp_version}</td>
									</tr>
									<tr>
										<td><strong>{__('Elementor Version', 'astrax-addons')}</strong></td>
										<td>{systemInfo.elementor_version}</td>
									</tr>
									<tr>
										<td><strong>{__('Server', 'astrax-addons')}</strong></td>
										<td>{systemInfo.server_software}</td>
									</tr>
									<tr>
										<td><strong>{__('Memory Limit', 'astrax-addons')}</strong></td>
										<td>{systemInfo.memory_limit}</td>
									</tr>
								</tbody>
							</table>
						</PanelBody>
					</Panel>
				)}
			</div>
		</div>
	);
}

document.addEventListener('DOMContentLoaded', () => {
	const root = document.getElementById('astrax-admin-app-root');
	if (root) {
		render(<AstraxAdminDashboard />, root);
	}
});
