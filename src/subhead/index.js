import { registerBlockType, createBlock } from "@wordpress/blocks"

import "./style.scss"

import Edit from "./edit"
import save from "./save"

registerBlockType("zinzolin/subhead", {
	supports: {
		html: false, // Prevent HTML editing
		multiple: false, // Can’t be used more than once
		reusable: false, // Can’t be converted to a reusable component
	},
	transforms: {
		from: [
			{
				type: "block",
				blocks: ["core/paragraph"],
				transform: ({content}) => {
					return createBlock("zinzolin/subhead", {
						content,
					});
				},
			},
		]
	},
	
	edit: Edit,
	save,
})