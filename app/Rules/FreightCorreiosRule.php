<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FreightCorreiosRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === 'CORREIOS') {
            $total = request()->input('height') + request()->input('width') + request()->input('lenght');

            if ($total > 200) {
                $fail('A soma das dimensões não pode ultrapassar 200cm caso o tipo de frete marcado for CORREIOS.');
            }

            if (request()->input('height') > 100) {
                $fail('A dimensão altura não pode ultrapassar 100cm caso o tipo de frete marcado for CORREIOS.');
            }

            if (request()->input('width') > 100) {
                $fail('A dimensão largura não pode ultrapassar 100cm caso o tipo de frete marcado for CORREIOS.');
            }

            if (request()->input('lenght') > 100) {
                $fail('A dimensão comprimento não pode ultrapassar 100cm caso o tipo de frete marcado for CORREIOS.');
            }
        }
    }
}
