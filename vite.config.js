import { defineConfig, loadEnv, normalizePath } from 'vite'
import liveReload from 'vite-plugin-live-reload'
import { viteStaticCopy } from 'vite-plugin-static-copy'
import path from 'path'

let rollupOptions = {
  input: {
    main: normalizePath(path.resolve(__dirname, `./src/main.js`)),
    app: normalizePath(path.resolve(__dirname, `./src/app.js`)),
  },
}

export default ({ mode }) => {
  process.env = { ...process.env, ...loadEnv(mode, process.cwd()) }
  return defineConfig({
    plugins: [
      liveReload([`${__dirname}/**/*.php`]),
      viteStaticCopy({
        targets: [
          {
            src: `src/assets`,
            dest: ``,
          },
        ],
      }),
    ],
    root: ``,
    base: `/`,
    build: {
      outDir: normalizePath(path.resolve(__dirname, `./dist`)),
      assetsDir: `./build`,
      emptyOutDir: true,
      manifest: true,
      target: `es2018`,
      rollupOptions,
      minify: true,
      write: true,
    },
    server: {
      cors: true,
      strictPort: true,
      host: true,
      port: process.env.VITE_SERVER_PORT ?? 3000,
      https: false,
    },
  })
}
