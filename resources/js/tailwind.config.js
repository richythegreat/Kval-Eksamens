/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class', 
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./resources/**/*.tsx",
    "./resources/**/*.ts",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'Segoe UI', 'Roboto', 'Helvetica', 'Arial'],
      },
      boxShadow: {
        'inner-md': 'inset 0 1px 1px 0 rgba(0,0,0,0.25)',
        'elev-1': '0 1px 2px rgba(0,0,0,0.5)',
        'elev-2': '0 10px 30px rgba(0,0,0,0.35)',
      },
      borderRadius: {
        '2xl': '1rem',
      },
      colors: {
        ink: {
          50: '#f6f6f7',
          900: '#0a0a0b',
        },
      },
    },
    container: {
      center: true,
      padding: '1rem',
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
};
