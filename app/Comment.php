<?php

namespace App;

use App\ValueObjects\Age;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Watson\Validating\ValidatingTrait;

/**
 * App\Comment
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereAge($value)
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
            'email'   => ['required', 'email', 'max:191'],
            'age'     => ['required', new \App\Rules\ValueObject(Age::class)],
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
}
