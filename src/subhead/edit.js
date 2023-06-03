import { __ } from "@wordpress/i18n"
import { useBlockProps, RichText } from "@wordpress/block-editor"

import "./editor.scss"

export default function Edit(props) {
	const blockProps = useBlockProps()

	return (
		<div {...blockProps}>
			<RichText
				tagName="p"
				placeholder={__( "Write your content here", "zinzolin_plugin")}
				value={props.attributes.content}
				className="subhead"
				onChange={content => props.setAttributes({content})}
			/>
		</div>
	)
}
