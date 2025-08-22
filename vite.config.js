import tailwindcss from '@tailwindcss/vite';
import path from 'path';
import { defineConfig, loadEnv, normalizePath } from 'vite';
import liveReload from 'vite-plugin-live-reload';
import { viteStaticCopy } from 'vite-plugin-static-copy';

let rollupOptions = {
  input: {
    main: normalizePath(path.resolve(__dirname, './resources/main.js')),
    constants: normalizePath(
      path.resolve(__dirname, './resources/constants.js'),
    ),
  },
};

export default ({ mode }) => {
  process.env = { ...process.env, ...loadEnv(mode, process.cwd()) };
  return defineConfig({
    plugins: [
      tailwindcss(),
      liveReload([`${__dirname}/**/*.php`]),
      viteStaticCopy({
        targets: [
          {
            src: 'resources/assets',
            dest: '',
          },
          {
            src: 'resources/tailwind-plugins',
            dest: '',
          },
        ],
      }),
    ],
    root: '',
    base: '/',
    build: {
      outDir: normalizePath(path.resolve(__dirname, './dist')),
      assetsDir: './build',
      emptyOutDir: true,
      manifest: true,
      target: 'es2018',
      rollupOptions,
      minify: true,
      write: true,
    },
    server: {
      cors: true,
      strictPort: true,
      host: true,
      port: process.env.VITE_SERVER_PORT || 3000,
      https: false,
    },
  });
};
