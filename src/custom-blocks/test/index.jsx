import metadata from './block.json'
import { registerBlockType } from '@wordpress/blocks'
import { useBlockProps, RichText } from '@wordpress/block-editor'
import { __ } from '@wordpress/i18n'

const { name } = metadata

registerBlockType(name, {
  edit: (props) => {
    const blockProps = useBlockProps()
    const {
      attributes: { content },
      setAttributes,
    } = props
    const onChange = (newContent) => {
      setAttributes({ content: newContent })
    }
    return (
      <div {...blockProps}>
        <RichText tagName='p' placeholder={`${__('Text')}...`} onChange={onChange} value={content} />
      </div>
    )
  },
})
