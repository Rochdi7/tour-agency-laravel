<?php 
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;
use Illuminate\Support\Facades\Log; // <<<--- IMPORT Log facade

class TrimStrings extends Middleware
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
        // Add any fields that legitimately contain arrays IF NEEDED
        // (e.g., if using a TagsInput or CheckboxList component directly in the form)
    ];

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        // <<< --- ADD THIS DEBUGGING BLOCK --- >>>
        if (!is_string($value) && !is_null($value) && !is_numeric($value) && !is_bool($value)) {
            // Log only if it's not a typical scalar type that trim wouldn't apply to anyway
            Log::warning("TrimStrings encountered non-string for key: [{$key}]. Type: [" . gettype($value) . "]");
            // You might want to inspect the value too:
            // Log::debug("Value for key [{$key}]: ", is_array($value) ? $value : [$value]);

             // TEMPORARILY return the value untrimmed to potentially prevent the crash
             // return $value; // Uncomment this line ONLY for temporary debugging if the error prevents saving
        }
        // <<< --- END DEBUGGING BLOCK --- >>>


        if (in_array($key, $this->except, true)) {
            return $value;
        }

        // Original logic (ensure it only tries to trim actual strings)
        return is_string($value) ? trim($value) : $value;
    }
}