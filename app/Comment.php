<?php

namespace App;

use App\Rules\ValueObject;
use App\ValueObjects\Age;
use App\ValueObjects\Email;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Watson\Validating\ValidatingTrait;

/**
 * App\Comment
 *
 * @author Matt Dawkins
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property string $email
 * @property string $comment
 * @property int $age
 */
class Comment extends Model
{
    use ValidatingTrait;

    /** @var bool */
    protected $throwValidationExceptions = true;

    /** @var array */
    protected $fillable = [
        'name',
        'email',
        'age',
        'comment',
    ];

    /** @var array */
    protected $rules;

    /**
     * Comment constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->rules = [
            'name'    => ['required', 'string', 'max:191'],
            'email'   => ['required', 'max:191', new ValueObject(Email::class)],
            'age'     => ['required', new ValueObject(Age::class)],
            'comment' => ['required', 'string'],
        ];
    }

    /**
     * Get the age as a value object
     *
     * @return Age
     * @throws ValidationException
     */
    public function age()
    {
        return new Age($this->age);
    }

    /**
     * Get the email as a value object
     *
     * @return Email
     * @throws ValidationException
     */
    public function email()
    {
        return new Email($this->email);
    }
}
