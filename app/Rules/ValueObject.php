<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * Class ValueObject
 *
 * This is a reusable validation rule for testing that a value can be used to create a certain value object
 *
 * @package App\Rules
 */
class ValueObject implements Rule
{
    /** @var string */
    protected $class;

    /** @var ValidationException */
    protected $exception;

    /**
     * Create a new rule instance.
     *
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /** @var \Funeralzone\ValueObjects\ValueObject $value */
        try {
            $className = $this->class;
            new $className($value);
        } catch (ValidationException $exception) {
            $this->exception = $exception;
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->exception->validator->errors()->first();
    }
}
