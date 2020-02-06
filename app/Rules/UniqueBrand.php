<?php

namespace ChemLab\Rules;

use ChemLab\Models\Chemical;
use Illuminate\Contracts\Validation\Rule as RuleContract;

class UniqueBrand implements RuleContract
{
    /**
     * Value to check for where clause
     *
     * @var int
     */
    protected $brandId;

    /**
     * Value to check for where clause
     *
     * @var int
     */
    protected $exceptId;

    /**
     * Value to check for where clause
     *
     * @var Chemical
     */
    protected $chemical;

    /**
     * Create a new rule instance.
     *
     * @param int|null $brandId
     * @param int|null $exceptId
     * @return void
     */
    public function __construct($brandId, $exceptId = null)
    {
        $this->brandId = $brandId;
        $this->exceptId = $exceptId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!$this->brandId)
            return true;

        $this->chemical = Chemical::UniqueBrand($this->brandId, $value, $this->exceptId)->first();

        return $this->chemical ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('chemicals.brand.error');
    }
}
