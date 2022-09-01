<?php
/*
	task
	1. Напишите функцию подготовки строки, которая заполняет шаблон данными из указанного объекта
	2. Пришлите код целиком, чтобы можно его было проверить
	3. Придерживайтесь code style текущего задания
	4. По необходимости - можете дописать код, методы
	5. Разместите код в гите и пришлите ссылку
*/

/**
 * Класс для работы с API
 *
 * @author		User Name
 * @version		v.1.0 (dd/mm/yyyy)
 */
class Api
{
	/**
	 * Заполняет строковый шаблон template данными из объекта object
	 *
	 * @author		User Name
	 * @version		v.1.0 (dd/mm/yyyy)
	 * @param		array $array
	 * @param		string $template
	 * @return		string
	 */
	public function get_api_path(array $array, string $template) : string
	{
		$result = '';

        $result = $this->set_results($array, $template);

		return $result;
	}

    public function set_results($array, $template)
    {
        $result = str_replace('%id%', $array['id'], $template);

        $get_template = $this->parse_template($template);
        $end_of_template = end($get_template);

        $result = str_replace($end_of_template, $array[$end_of_template], $get_template);

        $result = str_replace(' ', '%20', implode('/', $result));

        return $result;
    }

    public function parse_template($template)
    {
        $result = [];

        $result = explode('/', str_replace('%', '', $template));

        return $result;
    }
}

$user =
[
	'id'		=> 20,
	'name'		=> 'John Dow',
	'role'		=> 'QA',
	'salary'	=> 100
];

$api_path_templates =
[
	"/api/items/%id%/%name%",
	"/api/items/%id%/%role%",
	"/api/items/%id%/%salary%"
];

$api = new Api();

$api_paths = array_map(function ($api_path_template) use ($api, $user)
{
	return $api->get_api_path($user, $api_path_template);
}, $api_path_templates);

echo json_encode($api_paths);
echo "<br/>";
$expected_result = ['/api/items/20/John%20Dow','/api/items/20/QA','/api/items/20/100'];

echo json_encode($expected_result);
