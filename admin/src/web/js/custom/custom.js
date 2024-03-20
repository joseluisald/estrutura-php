const observer = lozad();
observer.observe();

if (cPage() !== 'login') {
	let sidebar_minimize_state = KTCookie.get("sidebar_minimize_state");

	document.body.setAttribute('data-kt-app-sidebar-minimize', sidebar_minimize_state);

	const currentTheme = "light";
	// const currentTheme = KTThemeMode.getMode();

	if (logs) console.log('currentTheme: ', currentTheme);
}