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
        '50': '#faf6f0',
        '100': '#efe6d6',
        '200': '#decaa9',
        '300': '#cdac7c',
        '400': '#c1945e',
        '500': '#ba8355',
        '600': '#a0623f',
        '700': '#864b37',
        '800': '#6e3f32',
        '900': '#5c352b',
        '950': '#331a15',
        },
         oliveShade: "#2F2B20",
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
