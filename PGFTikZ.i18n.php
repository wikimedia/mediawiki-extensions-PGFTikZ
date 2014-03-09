<?php
/**
 * Internationalisation for PGFTikZ
 *
 * @PGFTikZ.i18n.php
 * @ingroup Extensions
 */
$messages = array();

/** English
 * @author thibault marin
 */
$messages['en'] = array(
	// Description
	'pgftikz-desc' => 'Render PGF/TikZ graphs in wiki',

	// Error messages
	'pgftikz-error-title' => 'PGFTikZ parser error:',
	'pgftikz-error-emptyinput' => 'Empty input.',
	'pgftikz-error-imagelineparse' => 'Could not parse image line, expected something like ([[File:Image file name.ext|file link]]).',
	'pgftikz-error-apigetpagecontent' => 'Could not get image page content for comparision.',
	'pgftikz-error-apiedit' => 'Could not update file wikipage.',
	'pgftikz-error-apidelete' => 'Could not delete preview wikipage.',
	'pgftikz-error-nonpgffile' => 'Existing file is not PGF/TikZ-generated, not overwriting.',
	'pgftikz-error-preambleparse' => 'Error parsing LaTeX preamble.',
	'pgftikz-error-tmpdircreate' => 'Error creating temporary folder.',
	'pgftikz-error-texfilecreate' => 'Error creating LaTeX source file.',
	'pgftikz-error-latexnoout' => 'Error when running LaTeX (no output, is latex present?).',
	'pgftikz-error-latexcompil' => 'Error when running LaTeX (compilation error).',
	'pgftikz-error-dvipsnoout' => 'Error when running dvips (no output, is dvips present?).',
	'pgftikz-error-dvipscompil' => 'Error when running dvips (runtime error).',
	'pgftikz-error-epstoolnoout' => 'Error when running epstool (no output, is epstool present?).',
	'pgftikz-error-epstoolrun' => 'Error when running epstool (runtime error).',
	'pgftikz-error-convertnoout' => 'Error when running convert (no output, is convert present?).',
	'pgftikz-error-convertrun' => 'Error when running convert (runtime).',

	'pgftikz-error-uploadlocal_error_empty' => 'Error during upload (empty file).',
	'pgftikz-error-uploadlocal_error_missing' => 'Error during upload (filetype missing).',
	'pgftikz-error-uploadlocal_error_badtype' => 'Error during upload (bad filetype).',
	'pgftikz-error-uploadlocal_error_tooshort' => 'Error during upload (filename too short).',
	'pgftikz-error-uploadlocal_error_illegal' => 'Error during upload (illegal filename).',
	'pgftikz-error-uploadlocal_error_overwrite' => 'Error during upload (overwrite).',
	'pgftikz-error-uploadlocal_error_verify' => 'Error during upload (verification error).',
	'pgftikz-error-uploadlocal_error_hook' => 'Error during upload (hook aborted).',
	'pgftikz-error-uploadlocal_error_unknown' => 'Error during upload (unknown error).'
);

/** Message documentation
 * @author thibault marin
 */
$messages['qqq'] = array(
	'pgftikz-desc' => '{{desc}}',
	'pgftikz-error-title' => 'Generic title message displayed before the actual reported error',
	// Errors
	'pgftikz-error-emptyinput' => 'Displayed when parsing input and finding no text between <PGFTikZ> tags.',
	'pgftikz-error-imagelineparse' => 'Displayed when extraction of filename from image entry line (e.g. [[Image:filename.png]]) failed.',
	'pgftikz-error-apigetpagecontent' => 'Displayed when API call to get existing file failed.',
	'pgftikz-error-apiedit' => 'Displayed when API call failed to edit wikipage associated with uploaded image.',
	'pgftikz-error-apidelete' => 'Displayed when API call to delete preview wikipage.',
	'pgftikz-error-nonpgffile' => 'Displayed when a file with the target name was found, but the PGFTikZ header was not found (possibly a non PGFTikZ-generated file).',
	'pgftikz-error-preambleparse' => '<PGFTikZPreamble> tags not found in input.',
	'pgftikz-error-tmpdircreate' => 'Displayed when temporary folder creation failed.',

	# FIXME: Replace with real message documentation. Below are copies of the messages
#	'pgftikz-error-texfilecreate' => 'Error creating LaTeX source file.',
#	'pgftikz-error-latexnoout' => 'Error when running LaTeX (no output).',
#	'pgftikz-error-latexcompil' => 'Error when running LaTeX (compilation error).',
#	'pgftikz-error-dvipsnoout' => 'Error when running dvips (no output).',
#	'pgftikz-error-dvipscompil' => 'Error when running dvips (runtime error).',
#	'pgftikz-error-epstoolnoout' => 'Error when running epstool (no output).',
#	'pgftikz-error-epstoolrun' => 'Error when running epstool (runtime error).',
#	'pgftikz-error-convertnoout' => 'Error when running convert (no output).',
#	'pgftikz-error-convertrun' => 'Error when running convert (runtime).',

#	'pgftikz-error-uploadlocal_error_empty' => 'Error during upload (empty file).',
#	'pgftikz-error-uploadlocal_error_missing' => 'Error during upload (filetype missing).',
#	'pgftikz-error-uploadlocal_error_badtype' => 'Error during upload (bad filetype).',
#	'pgftikz-error-uploadlocal_error_tooshort' => 'Error during upload (filename too short).',
#	'pgftikz-error-uploadlocal_error_illegal' => 'Error during upload (illegal filename).',
#	'pgftikz-error-uploadlocal_error_overwrite' => 'Error during upload (overwrite).',
#	'pgftikz-error-uploadlocal_error_verify' => 'Error during upload (verification error).',
#	'pgftikz-error-uploadlocal_error_hook' => 'Error during upload (hook aborted).',
#	'pgftikz-error-uploadlocal_error_unknown' => 'Error during upload (unknown error).'
);


