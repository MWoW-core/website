<?php

namespace App\Scripts;

class CreateAccountScript extends Script
{
    /**
     * The account name
     *
     * @var string
     */
    public string $name;

    /**
     * The password
     *
     * @var string
     */
    public string $password;

    /**
     * Create a new script instance.
     *
     * @param string $name
     * @param string $password
     */
    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }


    /**
     * Get the name of the script.
     *
     * @return string
     */
    public static function name(): string
    {
        return "Create game account through Telnet (RA)";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function contents(): string
    {
        return "ACCOUNT CREATE {$this->name} {$this->password} {$this->password}";
    }
}
