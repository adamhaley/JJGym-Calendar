<?
class report_generator{
	var $outfile;
	var $landscape;
	var $paper;
	var $pixels;
	var $sourceurl;

	function __construct(){
		$this->outfile = 'report';
		$this->landscape = false;
		$this->paper = 'A4';
		$this->pixels = 1024;
	}

	function set_prop($prop,$value){
		eval("\$this->$prop = '$value';");
	}

	function get_prop($prop){
		eval("\$return = \$this->$prop;");
		return $return;
	}	

	function generate(){
		global $globalpath;
		global $modulepath;
		
		echo $globalpath;

		require_once($globalpath . 'html2ps/pipeline.class.php');
		parse_config_file($globalpath . 'html2ps/html2ps.config');

		$g_config = array(
                  'cssmedia'     => 'screen',
                  'renderimages' => true,
                  'renderforms'  => false,
                  'renderlinks'  => true,
                  'mode'         => 'html',
                  'debugbox'     => false,
                  'draw_page_border' => false
                  );

		$media = Media::predefined($this->get_prop('paper'));
		$media->set_landscape($this->get_prop('landscape'));
		$media->set_margins(array('left'   => 0,
                          'right'  => 0,
                          'top'    => 0,
                          'bottom' => 0));
		$media->set_pixels($this->get_prop('pixels'));

		$g_px_scale = mm2pt($media->width() - $media->margins['left'] - $media->margins['right']) / $media->pixels;
		$g_pt_scale = $g_px_scale * 1.43;

		$pipeline = new Pipeline;
		$pipeline->fetchers[]     = new FetcherURL;
		$pipeline->data_filters[] = new DataFilterHTML2XHTML;
		$pipeline->parser         = new ParserXHTML;
		$pipeline->layout_engine  = new LayoutEngineDefault;
		$pipeline->output_driver  = new OutputDriverFPDF($media);
		$pipeline->destination    = new DestinationFile($modulepath . 'reports/' . $this->outfile);

		$pipeline->process($this->get_prop('sourceurl'), $media);
	}
}
?>
