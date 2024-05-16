import imagemin from '@ixkaito/imagemin'
import imageminJpegtran from 'imagemin-jpegtran'
import imageminPngquant from 'imagemin-pngquant'

;(async () => {
  const files = await imagemin(['src/assets/images/**/*.{jpg,png}'], {
    destination: 'dist/assets/images',
    plugins: [
      imageminJpegtran(),
      imageminPngquant({
        quality: [0.6, 0.8],
      }),
    ],
  })
  console.log(`${files.length} images minified.`)
})()
