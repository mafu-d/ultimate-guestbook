<?php declare(strict_types=1);
/**
 * Age.php in guestbook
 * @author MattD
 */

namespace App\ValueObjects;

use Funeralzone\ValueObjects\Scalars\IntegerTrait;
use Funeralzone\ValueObjects\ValueObject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class Age
 * @package App\ValueObjects
 */
final class Age implements ValueObject
{
    use IntegerTrait;

    /**
     * Age constructor.
     *
     * @param int $age
     *
     * @throws ValidationException
     */
    public function __construct(int $age)
    {
        Validator::validate(
            ['age' => $age],
            ['age' => ['required', 'integer', 'gte:18', 'lte:120']]
        );
        $this->int = $age;
    }

    /**
     * Return the age as a string
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->int;
    }

    /**
     * Format the age for display purposes
     *
     * @return string
     */
    public function format(): string
    {
        return $this->int . ' yrs';
    }
}
