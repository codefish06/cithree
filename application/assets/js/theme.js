(function() {
  var STORAGE_KEY = 'themeMode';

  function getStoredTheme() {
    try {
      var stored = window.localStorage.getItem(STORAGE_KEY);
      if (stored === 'dark' || stored === 'light') {
        return stored;
      }
    } catch (e) {
      return null;
    }

    return null;
  }

  function getPreferredTheme() {
    var storedTheme = getStoredTheme();
    if (storedTheme) {
      return storedTheme;
    }

    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      return 'dark';
    }

    return 'light';
  }

  function saveTheme(theme) {
    try {
      window.localStorage.setItem(STORAGE_KEY, theme);
    } catch (e) {
      // Ignore storage failures.
    }
  }

  function syncToggleLabels(theme) {
    var nextLabel = theme === 'dark' ? 'Light' : 'Dark';
    var toggles = document.querySelectorAll('[data-theme-toggle]');

    toggles.forEach(function(toggle) {
      var labelNode = toggle.querySelector('[data-theme-label]');
      if (labelNode) {
        labelNode.textContent = nextLabel;
      }

      toggle.setAttribute('aria-pressed', String(theme === 'dark'));
      toggle.setAttribute('aria-label', 'Switch to ' + nextLabel.toLowerCase() + ' mode');
      toggle.setAttribute('title', 'Switch to ' + nextLabel.toLowerCase() + ' mode');
    });
  }

  function applyTheme(theme) {
    var root = document.documentElement;
    if (!root) {
      return;
    }

    root.setAttribute('data-bs-theme', theme);
    syncToggleLabels(theme);
  }

  function handleThemeToggleClick() {
    var currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
    var nextTheme = currentTheme === 'dark' ? 'light' : 'dark';

    applyTheme(nextTheme);
    saveTheme(nextTheme);
  }

  document.addEventListener('DOMContentLoaded', function() {
    var theme = getPreferredTheme();
    applyTheme(theme);

    document.querySelectorAll('[data-theme-toggle]').forEach(function(toggle) {
      toggle.addEventListener('click', handleThemeToggleClick);
    });

    if (window.matchMedia) {
      var mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
      var handlePreferenceChange = function(event) {
        if (getStoredTheme()) {
          return;
        }

        applyTheme(event.matches ? 'dark' : 'light');
      };

      if (typeof mediaQuery.addEventListener === 'function') {
        mediaQuery.addEventListener('change', handlePreferenceChange);
      } else if (typeof mediaQuery.addListener === 'function') {
        mediaQuery.addListener(handlePreferenceChange);
      }
    }
  });
})();
