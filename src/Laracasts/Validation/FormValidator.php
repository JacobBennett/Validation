<?php namespace Laracasts\Validation;

use Laracasts\Validation\FactoryInterface as ValidatorFactory;
use Laracasts\Validation\ValidatorInterface as ValidatorInstance;

abstract class FormValidator {

	/**
	 * @var string
	 */
	protected $context;

	/**
	 * @var ValidatorFactory
	 */
	protected $validator;

	/**
	 * @var ValidatorInstance
	 */
	protected $validation;

	/**
	 * @var array
	 */
	protected $messages = [];

	/**
	 * @param ValidatorFactory $validator
	 */
	function __construct(ValidatorFactory $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Validate the form data
	 *
	 * @param  mixed $formData
	 * @return mixed
	 * @throws FormValidationException
	 */
	public function validate($formData)
	{
		$formData = $this->normalizeFormData($formData);

		$this->validation = $this->validator->make(
			$formData,
			$this->getValidationRules(),
			$this->getValidationMessages()
		);

		if ($this->validation->fails())
		{
			throw new FormValidationException('Validation failed', $this->getValidationErrors());
		}

		return true;
	}

	/**
	 * @return array
	 */
	public function getValidationRules()
	{
		if( ! is_null($this->context) && array_key_exists($this->context, $this->rules)) return $this->rules[$this->context];
		
		return $this->rules;
	}

	/**
	 * @return FormValidator
	 */
	public function setContext($context)
	{
		$this->context = $context;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContext()
	{
		return $this->context;
	}

	/**
	 * @return mixed
	 */
	public function getValidationErrors()
	{
		return $this->validation->errors();
	}

	/**
	 * @return mixed
	 */
	public function getValidationMessages()
	{
		return $this->messages;
	}

	/**
	 * Normalize the provided data to an array.
	 *
	 * @param  mixed $formData
	 * @return array
	 */
	protected function normalizeFormData($formData)
	{
		// If an object was provided, maybe the user
		// is giving us something like a DTO.
		// In that case, we'll grab the public properties
		// off of it, and use that.
		if (is_object($formData))
		{
        	return get_object_vars($formData);
		}

		// Otherwise, we'll just stick with what they provided.
		return $formData;
	}

}
