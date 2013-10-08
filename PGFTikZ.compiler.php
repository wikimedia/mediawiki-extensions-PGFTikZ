<?php

class PGFTikZCompiler {

	/**
	 * Temporary folder name
	 */
	private $_foldName = "";

	/**
	 * Error message
	 */
	private $_errorMsg = "";

	/**
	 * Destructor (delete temporary folder)
	 */
	public function __destruct() {
		self::rmTempFiles( $this->_foldName );
	}

	/**
	 * Return the temporary folder name (to get the final image)
	 */
	public function getFolder() {
		return $this->_foldName;
	}

	/**
	 * Delete temporary files and folder used for LaTeX compilation
	 */
	private static function rmTempFiles ($dir) {
		if ( is_dir( $dir ) ) {
			wfRecursiveRemoveDir( $dir );
		}
	}

	/**
	 * Return latest error message
	 */
	public function getError() {
		return $this->_errorMsg;
	}

	/**
	 * Report error with content of log
	 */
	private function errorMsgLog( $msg, $log, $nLines = -1 ) {
		$log = explode( PHP_EOL, $log );
		if ( $nLines != -1 ) {
			$nLinesLog = count( $log );
			$log = array_slice( $log, $nLinesLog - $nLines + 1, $nLinesLog);
		}
		$log = preg_replace( "#" . $this->_foldName . "#", "", $log );
		$log = implode ( "<br />", $log );
		return htmlspecialchars( $msg ) . "<br />" . $log;
	}

	public function generateImage( $preambleStr, $latexContent, $imgFname,
	                               $dpi, $TEXLR ) {

		// Global parameters
		global $wgPGFTikZDefaultDPI;
		global $wgPGFTikZLaTeXPath;
		global $wgPGFTikZLaTeXOpts;
		global $wgPGFTikZdvipsPath;
		global $wgPGFTikZepstoolPath;
		global $wgImageMagickConvertCommand;

		// 1 - Check ability to compile LaTeX file
		// ---------------------------------------
		// Check if latex is present and if the desired file format can be
		// generated (might require imagemagick/epstool for tight bounding box).
// TODO
		// Commands
		$LATEX      = $wgPGFTikZLaTeXPath;
		$LATEX_OPTS = $wgPGFTikZLaTeXOpts;
		$DVIPS      = $wgPGFTikZdvipsPath;
		$EPSTOOL    = $wgPGFTikZepstoolPath;
		$CONVERT    = $wgImageMagickConvertCommand;

		// 2 - Create .tex file
		// --------------------
		// Store in temporary location (ensure writeable)

		// Build latex string
		// (see http://heinjd.wordpress.com/2010/04/28/
		// creating-eps-figures-using-tikz/)
		$latexStr  = '\documentclass{article}' . $TEXLR;
		$latexStr .= '\def\pgfsysdriver{pgfsys-dvips.def}' . $TEXLR;
		//$latexStr .= '\usepackage{nopageno}' . $TEXLR;
		$latexStr .= '\usepackage[usenames]{color}' . $TEXLR;
		$latexStr .= $preambleStr . $TEXLR;
		$latexStr .= '\begin{document}' . $TEXLR;
		$latexStr .= '\thispagestyle{empty}' . $TEXLR;
		$latexStr .= $latexContent;
		$latexStr .= '\end{document}' . $TEXLR;

		// Write to file
		$latexTmpDir = wfTempDir() . "/tmp_latex_" . rand(1,999999999);
		$this->_foldName = $latexTmpDir;
		if ( !is_dir( $latexTmpDir ) ) {
			if ( !mkdir( $latexTmpDir, 0700, true ) ) {
				$this->_errorMsg = errorMsg(
				    wfMessage ( 'pgftikz-error-tmpdircreate' ) );
				return false;
			}
		}
		$latexBaseFname = $latexTmpDir . "/tikz";
		$latexFname = $latexBaseFname . ".tex";
		$latexWriteRet = file_put_contents( $latexFname, $latexStr );
		if ( !$latexWriteRet ) {
			$this->_errorMsg = errorMsg(
			    wfMessage( 'pgftikz-error-texfilecreate' ) );
			return false;
		}

		// 3 - Generate image (compilation)
		// --------------------------------

		// External calls
		$cmd_latex = "$LATEX $LATEX_OPTS -output-directory=$latexTmpDir " .
		    wfEscapeShellArg( $latexFname ) . " &> $latexTmpDir/latex_log.txt";
		//print ("Running latex on tikz code\n(<$cmd_latex>)..." . "\n");
		wfShellExec( $cmd_latex, $latexRetVal );
		if ( !file_exists( "$latexBaseFname.dvi" ) || $latexRetVal != 0 ) {
			if ( file_exists( "$latexTmpDir/latex_log.txt" ) ) {
				$retLatex = file_get_contents( "$latexTmpDir/latex_log.txt" );
				if ( empty( $retLatex ) ) {
					$this->_errorMsg = errorMsg(
					    wfMessage( 'pgftikz-error-latexnoout' ) );
					return false;
				}
				$this->_errorMsg = $this->errorMsgLog(
				    wfMessage( 'pgftikz-error-latexcompil' ), $retLatex, 10 );
				return false;
			} else {
				$this->_errorMsg = errorMsg(
				    wfMessage( 'pgftikz-error-latexnoout' ) );
				return false;
			}
		}

		// Generate EPS
		$cmd_dvips = "$DVIPS -R -K0 -E " .
		    wfEscapeShellArg( $latexBaseFname ) . ".dvi " .
		    "-o $latexTmpDir/out.eps &> $latexTmpDir/dvips_log.txt";
		//print ("Running dvips on dvi\n(<$cmd_dvips>)..." . "\n");
		wfShellExec( $cmd_dvips, $dvipsRetVal );
		if ( !file_exists( "$latexTmpDir/out.eps" ) || $dvipsRetVal != 0 ) {
			if ( file_exists( "$latexTmpDir/dvips_log.txt" ) ) {
				$retDvips = file_get_contents( "$latexTmpDir/dvips_log.txt" );
				if ( empty( $retDvips ) ) {
					$this->_errorMsg = errorMsg(
					    wfMessage( 'pgftikz-error-dvipsnoout' ) );
					return false;
				}
				$this->_errorMsg = $this->errorMsgLog(
				    wfMessage( 'pgftikz-error-dvipscompil' ), $retDvips, 10 );
				return false;
			} else {
				$this->_errorMsg = errorMsg(
				    wfMessage( 'pgftikz-error-dvipsnoout' ) );
				return false;
			}
		}

		// Fix bounding box
		$cmd_eps = "$EPSTOOL --copy --bbox $latexTmpDir/out.eps " .
		    "$latexTmpDir/out_bb.eps &> $latexTmpDir/epstool_log.txt";
		//print ("Fixing bounding box\n(<$cmd_eps>)..." . "\n");
		wfShellExec( $cmd_eps, $epstoolRetVal );
		if ( !file_exists( "$latexTmpDir/out_bb.eps" ) ||
		     $epstoolRetVal != 0 ) {
			if ( file_exists( "$latexTmpDir/epstool_log.txt" ) ) {
				$retEpstool = file_get_contents(
				    "$latexTmpDir/epstool_log.txt" );
				if ( empty( $retEpstool ) ) {
					$this->_errorMsg = errorMsg(
					    wfMessage( 'pgftikz-error-epstoolnoout' ) );
					return false;
				}
				$this->_errorMsg = $this->errorMsgLog(
				    wfMessage( 'pgftikz-error-epstoolrun' ),
				    $retEpstool, 10 );
				return false;
			} else {
				$this->_errorMsg = errorMsg(
					wfMessage( 'pgftikz-error-epstoolnoout' ) );
				return false;
			}
		}

		// Convert to desired output
		$cmd_convert = "$CONVERT -density $dpi $latexTmpDir/out_bb.eps " .
		    "$latexTmpDir/" . wfEscapeShellArg( $imgFname ) .
		    " &> $latexTmpDir/convert_log.txt";
		//print ("Converting file\n(<$cmd_convert>)..." . "\n");
		wfShellExec( $cmd_convert, $convertRetVal );
		if ( !file_exists( "$latexTmpDir/$imgFname" ) ||
		     $convertRetVal != 0 ) {
			if ( file_exists( "$latexTmpDir/convert_log.txt" ) ) {
				$retConvert =
				    file_get_contents( "$latexTmpDir/convert_log.txt" );
				if ( empty( $retConvert ) ) {
					$this->_errorMsg = errorMsg(
					    wfMessage( 'pgftikz-error-convertnoout' ) );
					return false;
				}
				$this->_errorMsg = $this->errorMsgLog(
				    wfMessage( 'pgftikz-error-convertrun' ),
				    $retConvert, 10 );
				return false;
			} else {
				$this->_errorMsg = errorMsg(
				    wfMessage( 'pgftikz-error-convertnoout' ) );
				return false;
			}
		}
		return true;
	}


}

