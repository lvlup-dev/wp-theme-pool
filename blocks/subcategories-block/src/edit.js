/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { useState, useEffect } from '@wordpress/element';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( props ) {
	const [ subcategories, setSubcategories ] = useState( [] );

	// Récupérer la catégorie en cours.
	const currentCategory = useSelect( ( select ) => {
		const { getCurrentPost } = select( 'core/editor' );
		const post = getCurrentPost();
		if ( post && post.categories && post.categories.length > 0 ) {
			return post.categories[ 0 ]; // considérons la première catégorie comme la catégorie principale
		}
		return null;
	}, [] );

	useEffect( () => {
		if ( currentCategory ) {
			fetch( `/wp-json/wp/v2/categories?parent=${ currentCategory }` )
				.then( response => response.json() )
				.then( data => {
					setSubcategories( data );
				} );
		}
	}, [ currentCategory ] );

	return (
		<div { ...props }>
			<h4>Sous-catégories :</h4>
			<ul>
				{ subcategories.map( cat => (
					<li key={ cat.id }>
						<a href={ cat.link }>{ cat.name }</a>
					</li>
				) ) }
			</ul>
		</div>
	);
}
