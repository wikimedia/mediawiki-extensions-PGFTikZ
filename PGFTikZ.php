<?php

/**
 * PGFTikZ - this extension creates images from PGF/TikZ input (requires LaTeX
 * on the server).
 *
 * To activate this extension, add the following into your LocalSettings.php file:
 * require_once('$IP/extensions/PGFTikZ.php');
 *
 * @ingroup Extensions
 * @authors Thibault Marin, Markus Bürkler
 * @version 0.1
 * @link http://www.mediawiki.org/wiki/Extension:PGFTikZ
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if( !defined( 'MEDIAWIKI' ) )
{
        echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
        die( -1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'PGFTikZ',
	'version'        => '0.3.0',
	'author'         => array( 'Thibault Marin', 'Markus Bürkler' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:PGFTikZ',
	'descriptionmsg' => 'pgftikz-desc'
);

/**
 * Extension class
 */
$wgAutoloadClasses['PGFTikZHooks'] = dirname( __FILE__ ) . '/PGFTikZ.hooks.php';
$wgAutoloadClasses['PGFTikZParser'] = dirname( __FILE__ ) . '/PGFTikZ.parser.php';
$wgAutoloadClasses['PGFTikZCompiler'] = dirname( __FILE__ ) . '/PGFTikZ.compiler.php';

/**
 * Register hooks
 */
$wgHooks['ParserFirstCallInit'][] = 'PGFTikZHooks::onPGFTikZParserInit';
$wgHooks['ParserAfterTidy'][]     = 'PGFTikZHooks::onPGFTikZAfterTidy';

/**
 * Internationalization
 */
$wgMessagesDirs['PGFTikZ'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['PGFTikZ'] = dirname( __FILE__ ) . '/PGFTikZ.i18n.php';

/**
 * Parameters (modify in LocalSettings.php)
 */

// Default resolution for generated images
$wgPGFTikZDefaultDPI = 300;

// Full path to latex executable (assume in path if empty)
$wgPGFTikZLaTeXPath = 'latex';

// Extra options to latex executable (e.g. --shell-escape for special TikZ
// rendering)
$wgPGFTikZLaTeXOpts = '-no-shell-escape';

// Full path to 'dvips' executable
$wgPGFTikZdvipsPath = 'dvips';

// Either use epstool+imagemagick or ghostscript to generate image
$wgPGFTikZuseghostscript = true;

// Full path to 'epstool' executable
$wgPGFTikZepstoolPath = 'epstool';

// Full path to 'ghostscript' executable
$wgPGFTikZghostScriptPath = 'gs';

// Use standalone LaTeX package
$wgPGFTikZLaTeXStandalone = true;

