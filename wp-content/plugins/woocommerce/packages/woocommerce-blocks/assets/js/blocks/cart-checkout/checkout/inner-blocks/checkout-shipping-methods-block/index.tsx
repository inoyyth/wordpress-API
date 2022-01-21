/**
 * External dependencies
 */
import { Icon, truck } from '@woocommerce/icons';
import { registerFeaturePluginBlockType } from '@woocommerce/block-settings';

/**
 * Internal dependencies
 */
import { Edit, Save } from './edit';
import attributes from './attributes';
import metadata from './block.json';

registerFeaturePluginBlockType( metadata, {
	icon: {
		src: <Icon srcElement={ truck } />,
		foreground: '#7f54b3',
	},
	attributes,
	edit: Edit,
	save: Save,
} );
