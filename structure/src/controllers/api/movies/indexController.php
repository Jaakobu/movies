<?php
/**	
 * Get all movies
 * 
 * Call : GET api/v1/movies
 */
function getAll() {
	global $db;

	header('Content-Type: application/json');

	// Options filters
	$options = options();
	$limit = (int) $options['limit'];
	$order = order($options['order']);
	$fieldOrder = fieldOrder($options['fieldOrder']);

	if (is_int($fieldOrder)) :
		http_response_code($fieldOrder);
		return 'Not valid field order';
	endif;

	$sql = "SELECT * FROM movies ORDER BY $fieldOrder $order LIMIT $limit";
	$request = $db->query($sql);
	$data = $request->fetchAll();

	
	http_response_code(200);

	return json_encode($data);
}


function options() {
	$options = [
		'limit' => 10,
		'order' => 'desc',
		'fieldOrder' => 'id'
	];

	foreach ($options as $key => $value) :
		if (!empty($_GET[$key])) :
			$options[$key] = $_GET[$key];
		endif;
	endforeach;

	return $options;
}


function order($order) {
	if ($order == 'desc') :
		$result = 'DESC';
	else :
		$result = 'ASC';
	endif;

	return $result;
}

function fieldOrder($field) {
	$valideFields = ['id', 'created', 'title'];
	if (in_array($field, $valideFields)) : 
		$result = $field;
	else: 
		$result = 400;
	endif;

	return $result;
}

echo getAll();