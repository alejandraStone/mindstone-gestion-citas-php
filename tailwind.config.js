/*
cd C:\xampp\htdocs\EjerciciosHtdocs\mindStone
npx tailwindcss -i ./public/css/styles.css -o ./public/css/output.css --watch
*/
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./public/**/*.{html,js,jsx,php}",
    "./app/**/*.{html,js,jsx,php}",
    "./public/inicio.php", 
    "./**/*.php", // Por si hay archivos PHP sueltos en la raíz o en otras carpetas
  ],
  safelist: [
  'w-6', 'h-6',//añado clase que Tailwind no reconoce por falta de uso
  'w-8', 'h-8',
  'w-10', 'h-10',
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50: "#faf6f2",
          100: "#f0e7d8",
          200: "#e7d7c1",
          300: "#d7bc9a",
          400: "#c69c71",
          500: "#ba8355",
          600: "#ac704a",
          700: "#8f5a3f",
          800: "#744a38",
          900: "#5f3e2f",
          950: "#321e18",
        },
         oliveShade: "#6F6945",
         lightOlive: "#CECDB9",
      },
      fontFamily: {
        normal: ["Manrope", "sans-serif"],
        titulo: ["PlayFair", "sans-serif"]
      },
    },
  },
  plugins: [],
};
