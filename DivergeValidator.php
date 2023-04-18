<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class DivergeValidator implements ValidationRule, DivergeInterface
{
    private float $allowableDeviation;
    private float $resultDeviation;

    public function __construct(float $allowableDeviation)
    {
        $this->allowableDeviation = $allowableDeviation;
        $this->resultDeviation = 0;
    }
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = request()->all();

        if (!$this->diffPrice($data['newPrice'], $data['currentPrice'])) {
            $fail("Цена отклоняется больше, чем на {$this->getDeviation()}% от допустимого отклонения");
        }
    }

    public function diffPrice(float $new, float $out): bool
    {
        // Выполняем проверку на отклонение цены.
        $deviation = ($new - $out) / $out * 100; // Расчет отклонения в процентах
        $this->resultDeviation = $deviation;
        return abs($deviation) <= $this->allowableDeviation; // Возвращаем результат проверки
    }

    public function getDeviation(): float
    {
        return $this->resultDeviation;
    }
}
