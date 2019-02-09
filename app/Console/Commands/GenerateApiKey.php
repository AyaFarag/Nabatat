<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "apikey:generate";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generates a random API_KEY";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = base_path(".env");

        if (file_exists($path)) {
            $old = env("API_KEY");
            $key = $this -> generateRandomString(128);
            file_put_contents($path, str_replace(
                "API_KEY=" . $old, "API_KEY=" . $key,
                file_get_contents($path)
            ));
            return $this->info("Application's API key [$key] was set successfully.");
        }
        $this->error("The .env file doesn't exist.");
    }

    private function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
