<?php
/**
 * Return id if exist into url param
 */
function getId() {
	if (!empty($_GET['id'])) :
		return $_GET['id'];
	endif;
}

function checkFields(array $requireFields) {
	$errorsFieldsPost = [];
	$errorsFieldsFiles = [];

	if (!empty($_POST)) :
		$errorsFieldsPost = checkFieldsValue($_POST, $requireFields);
	endif;

	if (!empty($_FILES)) :
		$errorsFieldsFiles = checkFieldsValue($_FILES, $requireFields);
	endif;

	$errorsFields = array_merge($errorsFieldsPost, $errorsFieldsFiles);
		
	if (!empty($errorsFields)) :
		notif('Merci de valider les informations de votre formulaire.');
	endif;

	return $errorsFields;
}

function checkFieldsValue($data, $requireFields) {
	$errorsFields = [];

	if (!empty($data)) :
		foreach ($data as $key => $value) :
			if (
				!empty($requireFields[$key]) && empty($value) ||
				is_array($value) && empty($value['name'])
			) :
				$errorsFields[$key] = $requireFields[$key]['message'];
			elseif (!empty($requireFields[$key]['rule'])) :
				
				if (is_array($requireFields[$key]['rule'])) :
					$rule = $requireFields[$key]['rule']['name']($key, $requireFields[$key]['rule']['options']);
				else :
						$rule = $requireFields[$key]['rule']($data[$key], $key);
				endif;

				if ($rule) :
					$errorsFields[$key] = $rule;
				endif;
			endif;
		endforeach;
	endif;

	return $errorsFields;
}


function errorField(array $errors, string $field): array
{
	$results['message'] = '';
	$results['class'] = '';

	if (!empty($errors[$field])) :
		$results['message'] = '<div class="invalid-feedback">' . $errors[$field] . '</div>';
		$results['class'] = ' is-invalid';
	endif;

	return $results;
}


/**
 * Complete field value if exist $_POST['fieldName']
 * 
 * @param string $fieldName current field name
 */
function valueField(string $fieldName) {
	if (!empty($_POST[$fieldName])) :
		return $_POST[$fieldName];
	endif;
}


/**	
 * Complete field type select if exist and value === current $_POST['fieldname']
 * 
 * @param string $fieldname current field name
 * @param string $value current field value
 */
function valueFieldSelect(string $fieldName, string $value) {
	if (!empty($_POST[$fieldName]) && $_POST[$fieldName] === $value) :
		return ' selected';
	endif;
}


/**	
 * Validate email
 * 
 * @param string $mail
 */
function validateEmail(string $mail, $fieldName = false) {
	if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) :
		return 'Merci de renseigner un email avec un format valide.';
	endif;
}


function validatePassword($password, $fieldName = false) {
	if (!preg_match('/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,50})/', $password)) :
		return 'Merci de renseigner un mot de passe au bon format.';
	endif;
}

/**
 * Validate same value user 'Confirm' field
 */
function validateSame($field, $fieldName = false) {
	$originalField = str_replace('Confirm', '', $fieldName);
	
	if ($field !== $_POST[$originalField]) :
		return 'Merci de faire correspondre les deux champs';
	endif;
}


/**	
 * Validate slug format
 */
function validateSlug($field, $fieldName = false) {
	if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $field)) :
		return 'Merci de renseigner un slug au bon format.';
	endif;
}


/**
 * Validate date sql format
 */
function validateDate(string $field, $fieldName = false) {
	if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $field)) :
		return 'Merci de renseigner une  date au bon format YYYY-MM-DD.';
	endif;
}


/**
 * Validate number format
 */
function validateInt(string $field, $fieldName = false) {
	if (!filter_var($field, FILTER_VALIDATE_INT)) :
		return 'Merci de renseigner un nombre entier.';
	endif;
}


/**
 * Validate image format
 */
function validateImage(string $field, array $options) {
	if (!empty($options['maxSize'])) :
		$maxSize = $options['maxSize'];
	else :
		$maxSize = 2097152;
	endif;

	return uploadFile(FILES . $options['path'], $field, $options['extensions'], $maxSize);
}
