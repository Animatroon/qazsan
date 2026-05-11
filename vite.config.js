import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  root: '.',
  publicDir: 'public',
  base: process.env.VITE_BASE_URL ?? '/',
  server: {
    port: 5173,
    open: true,
    host: true,
  },
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'index.html'),
        about: resolve(__dirname, 'about.html'),
        treatment: resolve(__dirname, 'treatment.html'),
        accommodation: resolve(__dirname, 'accommodation.html'),
        contacts: resolve(__dirname, 'contacts.html'),
        sport: resolve(__dirname, 'sport.html'),
        conferences: resolve(__dirname, 'conferences.html'),
        services: resolve(__dirname, 'services.html'),
        gallery: resolve(__dirname, 'gallery.html'),
        booking: resolve(__dirname, 'booking.html'),
        procurement: resolve(__dirname, 'procurement.html'),
        antiCorruption: resolve(__dirname, 'anti-corruption.html'),
        vacancies: resolve(__dirname, 'vacancies.html'),
        blog: resolve(__dirname, 'blog.html'),
        blogSingle: resolve(__dirname, 'blog-single.html'),
        accommodationRoom: resolve(__dirname, 'accommodation-room.html'),
        appeal: resolve(__dirname, 'appeal.html'),
        styleGuide: resolve(__dirname, 'style-guide.html'),
      },
    },
  },
});
