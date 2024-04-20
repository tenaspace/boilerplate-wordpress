import imagemin from '@ixkaito/imagemin'
import imageminJpegtran from 'imagemin-jpegtran'
import imageminOptipng from 'imagemin-optipng'

const input = process.argv[2]
const dest = process.argv[3]

if (!input) throw new Error()
;(async () => {
  const files = await imagemin([input], {
    destination: dest,
    plugins: [imageminJpegtran(), imageminOptipng()],
  })
  console.log(`${files.length} images minified.`)
})()
