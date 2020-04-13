<?php 
function addMovies($data) {
	global $db;

	$sql = 'INSERT INTO movies (title, description, releaseDate, viewer) VALUES (:title, :description, :releaseDate, :viewer)';
	$request = $db->prepare($sql);
	$result = $request->execute($data);

	http_response_code(200);
	return $result;
}

$requireFields = [
	'title' => 'string',
	'description' => 'string',
	'releaseDate' => 'date',
	'viewer' => 'int'
];

function checkFieldsApi(array $requireFields) {
	header('Content-Type: application/json');
	header('Access-Control-Allow-Headers: Content-Type');
	header("Access-Control-Allow-Origin: *");

	$getData = file_get_contents('php://input');
	$data = json_decode($getData, true);

	if (!empty($data)) :
		$valide = true;
		foreach ($requireFields as $key => $value) :
			if (empty($data[$key])) :
				$valide = false;
			endif;
		endforeach;

		if ($valide) :
			if (checkType($requireFields, $data)) :
				$result = addMovies($data);
			else :
				http_response_code(422);
				$result = 'Invalid field format.';
			endif;
		else :
			http_response_code(422);
			$result = 'Required fields : "title", "description", "releaseDate", "viewer".';
		endif;
	else :
		http_response_code(422);
		$result = 'Required fields : "title", "description", "releaseDate", "viewer".';
	endif;

	return json_encode($result);
}
echo checkFieldsApi($requireFields);


function checkType($requireFields, $data): bool
{
	$valide = true;

	foreach ($data as $key => $value) :	
		switch ($requireFields[$key]) {
			case 'int':
				$value = (int) $value;
				if ($value === 0 || !is_int($value)) :
					$valide = false;
				endif;
				break;
			case 'string':
				if (!is_string($value)) :
					$valide = false;
				endif;
				break;
			case 'date':
				if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $value) || !strtotime($value)) :
					$valide = false;
				endif;
				break;
		}
	endforeach;

	return $valide;
}
