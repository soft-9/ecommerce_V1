module.exports = {
  content: [
    "./resources/**/*.js",
    "./resources/**/*.jsx",
    "./resources/**/*.ts",
    "./resources/**/*.tsx",
    "./resources/**/*.blade.php",
  ],
  darkMode: 'class', // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        dark: {
          bg: '#121212',
          hoverBg: '#1F1F1F',
          buttonBg: '#333333',
          text: '#E0E0E0',
          hoverText: '#FFFFFF',
        },
        light: {
          bg: '#FAFAFA',
          hoverBg: '#F0F0F0',
          buttonBg: '#E0E0E0',
          text: '#333333',
          hoverText: '#000000',
        },
        primary: {
          100: '#FF6F61',
          200: '#FF3D00',
          300: '#DD2C00',
        },
        secondary: {
          100: '#6EC6FF',
          200: '#2196F3',
          300: '#0D47A1',
        },
      },
    },
  },
  plugins: [],
};
