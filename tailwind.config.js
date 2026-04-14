/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                'agro-green': '#064e3b', // O verde escuro que pediste
            }
        },
    },
    plugins: [],
}