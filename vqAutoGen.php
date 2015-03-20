<?php
class vqAutoGen {
	
	private $filename;
	private $fileToWrite;
	private $version    = '1.0.0';
	private $id         = '';
	private $operations = array();

	public function __construct($fileToWrite = null, $filename = null) {
		$this->fileToWrite = $fileToWrite;
		$this->filename    = $filename;
	}

	public function setOptions($options) {
		if (isset($options['f'])) {
			$this->fileToWrite = $options['f'];
		}

		if (isset($options['i'])) {
			$this->id = $options['i'];
		}

		if (isset($options['v'])) {
			$this->version = $options['v'];
		}
	}

	public function replace($search, $replace, $filename = null) {
		if (!isset($this->filename) && !isset($filename)) {
			echo __FILE__ . ' : ' . __LINE__ . ' - Error no file name set.'
			exit;
		}

		if (!is_null($filename)) {
			$this->filename = $filename;
		}

		$this->operations[] = array(
			'position' => 'replace', 
			'search'   => $search, 
			'replace'  => $replace,
			'filename' => is_null($filename) ? $this->filename : $filename
		);

		return $this;
	}

	public function addBefore($search, $replace, $filename = null) {
		if (!isset($this->filename) && !isset($filename)) {
			echo __FILE__ . ' : ' . __LINE__ . ' - Error no file name set.'
			exit;
		}

		if (!is_null($filename)) {
			$this->filename = $filename;
		}

		$this->operations[] = array(
			'position' => 'before', 
			'search'   => $search, 
			'replace'  => $replace,
			'filename' => is_null($filename) ? $this->filename : $filename
		);

		return $this;
	}

	public function addAfter($search, $replace, $filename = null) {
		if (!isset($this->filename) && !isset($filename)) {
			echo __FILE__ . ' : ' . __LINE__ . ' - Error no file name set.'
			exit;
		}

		if (!is_null($filename)) {
			$this->filename = $filename;
		}

		$this->operations[] = array(
			'position' => 'after', 
			'search'   => $search, 
			'replace'  => $replace,
			'filename' => is_null($filename) ? $this->filename : $filename
		);

		return $this;
	}

	public function addInlineBefore($search, $replace, $filename = null) {
		if (!isset($this->filename) && !isset($filename)) {
			echo __FILE__ . ' : ' . __LINE__ . ' - Error no file name set.'
			exit;
		}

		if (!is_null($filename)) {
			$this->filename = $filename;
		}

		$this->operations[] = array(
			'position' => 'ibefore', 
			'search'   => $search, 
			'replace'  => $replace,
			'filename' => is_null($filename) ? $this->filename : $filename
		);

		return $this;
	}

	public function addInlineAfter($search, $replace, $filename = null) {
		if (!isset($this->filename) && !isset($filename)) {
			echo __FILE__ . ' : ' . __LINE__ . ' - Error no file name set.'
			exit;
		}

		if (!is_null($filename)) {
			$this->filename = $filename;
		}

		$this->operations[] = array(
			'position' => 'iafter', 
			'search'   => $search, 
			'replace'  => $replace,
			'filename' => is_null($filename) ? $this->filename : $filename
		);

		return $this;
	}

	public function top($search, $replace, $filename = null) {
		if (!isset($this->filename) && !isset($filename)) {
			echo __FILE__ . ' : ' . __LINE__ . ' - Error no file name set.'
			exit;
		}

		if (!is_null($filename)) {
			$this->filename = $filename;
		}

		$this->operations[] = array(
			'position' => 'top', 
			'search'   => $search, 
			'replace'  => $replace,
			'filename' => is_null($filename) ? $this->filename : $filename
		);

		return $this;
	}

	public function bottom($search, $replace, $filename = null) {
		if (!isset($this->filename) && !isset($filename)) {
			echo __FILE__ . ' : ' . __LINE__ . ' - Error no file name set.'
			exit;
		}

		if (!is_null($filename)) {
			$this->filename = $filename;
		}

		$this->operations[] = array(
			'position' => 'bottom', 
			'search'   => $search, 
			'replace'  => $replace,
			'filename' => is_null($filename) ? $this->filename : $filename
		);

		return $this;
	}

	public function generateXml() {
		$output  = '<?xml version="1.0" encoding="UTF-8"?>';
		$output .= '<modification>';
		$output .= '<id>' . $this->id . '</id>';
		$output .= '<version>' . $this->version . '</version>';
		$output .= '<vqmver>2.3.0</vqmver>';
		$output .= '<author>esterling.co.uk</author>';

		foreach ($this->operations as $operation) {
			$output .= '<file name="' . (is_array($operation['filename']) ? implode(', ', $operation['filename']) : $operation['filename']) . '">';
			$output .= '<operation error="abort">';
			$output .= '<search position="' . $operation['position'] . '">';
			$output .= '<![CDATA[' . $operation['search'] . ']]>';
			$output .= '</search>';
			$output .= '<add>';
			$output .= '<![CDATA[' . $operation['replace'] . ']]>';
			$output .= '</add>';
			$output .= '</operation>';
			$output .= '</file>';
		}

		$output .= '</modification>';

		return $output;
	}

	public function writeXml($output, $fileToWrite = null) {
		if (isset($fileToWrite)) {
			$this->fileToWrite = $fileToWrite;
		}
		
		$file     = getcwd() . '\\xml\\' . $this->fileToWrite;
		$fileInfo = new SplFileInfo($this->fileToWrite);
		
		if ($fileInfo->getExtension() != 'xml') {
			$file .= '.xml';
		}

		$filePointer = fopen($file, "w");
		$fileOutput  = fwrite($filePointer, $output);
		fclose($filePointer);
		chmod($file, 0777);
	}
}