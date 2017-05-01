<?php

namespace RachidLaasri\LaravelInstaller\Controllers;

use App\Http\Controllers\Controller;
use RachidLaasri\LaravelInstaller\Helpers\DatabaseManager;

class DatabaseController extends Controller
{

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        $response = $this->databaseManager->migrateAndSeed();
        if($response['status'] == 'danger')
            return redirect()->route('LaravelInstaller::environment')->with(['message' => $response['message']]);


        return redirect()->route('LaravelInstaller::final')
            ->with(['message' => $response['message']]);
    }
}
