<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;
use function app;
use function app_path;
use Throwable;
use function str_replace;
use const DIRECTORY_SEPARATOR;

class ValidScriptName implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @throws Throwable
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $namespace = app()->getNamespace();

        foreach (File::files(app_path('Scripts')) as $file) {
            /** @var SplFileInfo $script */
            $script = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($file->getPathname(), app_path().DIRECTORY_SEPARATOR)
                );

            if ($script::name() === $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'the given :value is not a valid Script name.';
    }
}
