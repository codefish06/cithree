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
      // Ignore storage failures (private mode / disabled storage).
    }
  }

  function applyTheme(theme) {
    if (!document.body) {
      return;
    }

    var isDark = theme === 'dark';
    document.body.classList.toggle('dark-mode', isDark);
    document.body.setAttribute('data-theme', theme);
    syncToggleLabels(theme);
  }

  function syncToggleLabels(theme) {
    var toggles = document.querySelectorAll('[data-theme-toggle]');
    var nextLabel = theme === 'dark' ? 'Light' : 'Dark';

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

  function createToggleButton() {
    var button = document.createElement('button');
    button.id = 'theme-toggle';
    button.type = 'button';
    button.className = 'theme-toggle-btn theme-toggle-floating';
    button.setAttribute('data-theme-toggle', 'true');
    button.innerHTML = '<span class="theme-toggle-icon" aria-hidden="true">T</span><span data-theme-label>Dark</span>';
    return button;
  }

  function ensureToggleButton() {
    var toggle = document.getElementById('theme-toggle');

    if (!toggle) {
      toggle = createToggleButton();
      var headerRow = document.querySelector('.header-row');

      if (headerRow) {
        toggle.classList.remove('theme-toggle-floating');
        headerRow.appendChild(toggle);
      } else {
        document.body.appendChild(toggle);
      }
    }

    if (!toggle.hasAttribute('data-theme-toggle')) {
      toggle.setAttribute('data-theme-toggle', 'true');
    }

    return toggle;
  }

  function handleThemeToggleClick() {
    var isDark = document.body.classList.contains('dark-mode');
    var nextTheme = isDark ? 'light' : 'dark';

    applyTheme(nextTheme);
    saveTheme(nextTheme);
  }

  document.addEventListener('DOMContentLoaded', function() {
    var theme = getPreferredTheme();
    applyTheme(theme);

    var toggle = ensureToggleButton();
    toggle.addEventListener('click', handleThemeToggleClick);

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
