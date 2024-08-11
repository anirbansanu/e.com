<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class MigrationController extends Controller
{
    /**
     * Run migrations by file name or all if not provided.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function runMigration(Request $request)
    {
        $fileName = $request->get('file_name',null);

        if ($fileName) {
             // Ensure the file name does not contain any path traversal characters
             $fileName = basename($fileName);

             $migrationPath = 'database/migrations/' . $fileName . '.php';
            if (file_exists(base_path($migrationPath))) {
                // return $migrationPath;

                $result = Artisan::call('migrate', ['--path' => $migrationPath]);
                $output = Artisan::output();

                return response()->json(['message' => 'Migration file executed successfully.', 'output' => $output, 'result' => $result]);
            } else {
                return response()->json(['error' => 'Migration file not found.'], 404);
            }
        } else {
            // Run all migrations
            $result = Artisan::call('migrate');
            $output = Artisan::output();
            return response()->json(['message' => 'All migrations executed successfully.', 'output' => $output, 'result' => $result]);
        }
    }
}
