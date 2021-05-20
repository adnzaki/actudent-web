<?php namespace Actudent\Core\Config;

class ActudentParserPlugin
{
    /**
	 * @param array $params
	 *
	 * @return \CodeIgniter\View\Parser
	 */
	public static function include(array $params = [])
	{
		$parser = \Config\Services::parser();
		return $parser->render(...$params);
	}

	/**
	 * @param array $params
	 *
	 * @return void
	 */
	public static function menuActive(array $params = [])
	{
		$uri = $params['uri'] ?? '';
		$class = $params['class'] ?? 'active';
		$exact = $params['exact'] ?? '';

		// Is URI params PascalCase?
        preg_match_all('/[A-Z]/', $uri, $matches);
		$split = preg_split('/[A-Z]/', $uri);
		
		// If yes, manipulate the URI params
        if(count($matches[0]) > 0)
        {
            $str = '';
            for($i = 0; $i < count($matches[0]); $i++)
            {
				// create the stripe
				$strip = (count($matches[0]) - $i !== 1) ? '-' : '';
				
				// generate new string to match URI with kebab-case style
                $str .= strtolower($matches[0][$i]) . $split[$i+1] . $strip;
			}

			$uri = $str;
        }

		return menu_active($uri, $class);
	}
}