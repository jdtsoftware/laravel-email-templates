<?php
namespace JDT\LaravelEmailTemplates\Engines;

use Illuminate\View\Engines\EngineInterface;

class StringEngine implements EngineInterface
{
    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array   $data
     * @return string
     */
    public function get($path, array $data = [])
    {
    	$obLevel = ob_get_level();
    	ob_start();

    	extract($data, EXTR_SKIP);
    	echo $path;

    	return ob_get_clean();
    }
}