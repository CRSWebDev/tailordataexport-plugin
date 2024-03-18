<?php namespace CRSCompany\TailorDataExport\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Storage;
use October\Rain\Support\Facades\Flash;
use October\Rain\Support\Facades\Input;
use function PHPUnit\Framework\directoryExists;

/**
 * Admin Page Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class AdminPage extends Controller
{

    /**
     * @var array required permissions
     */
    public $requiredPermissions = ['crscompany.tailordataexport.adminpage'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('CRSCompany.TailorDataExport', 'tailordataexport', 'adminpage');
    }

    /**
     * index action
     */

    public function index() {

    }

    public function onGetTables() {
        $tables = \DB::select('SHOW TABLES');
        $tables = array_map('current', $tables);

        $tables = array_filter($tables, function($table) {
            return str_contains($table, 'xc_');
        });

        $exportData = [];

        foreach ($tables as $table) {
            $exportData[$table] = \DB::select('SELECT * FROM ' . $table);
        }

        return $exportData;
    }

    public function onImportData() {
        $file = Input::file('importFile');

        $file = json_decode(file_get_contents($file->getRealPath()), true);

        foreach ($file as $table => $data) {
            $tableName = $table;

            \DB::table($tableName)->truncate();

            \DB::table($tableName)->insert($data);
        }

        Flash::success('Data imported successfully');

        return 'success';
    }

    public function onExportStorage() {
        $storageDir = storage_path('app');

        return $this->zip($storageDir);
    }

    public function onImportStorage() {
        $file = Input::file('importFile');

        $zip = new \ZipArchive();
        $zip->open($file);
        $zip->extractTo(storage_path('app'));
        $zip->close();

        Flash::success('Storage imported successfully');

        return 'success';
    }

    public function zip($source, $destination = null) {
        if (is_null($destination)) {
            $destination = storage_path('app') . 'media.zip';
        }
        if (extension_loaded('zip')) {

            if (file_exists($source)) {
                $zip = new \ZipArchive();

                if ($zip->open($destination, \ZipArchive::CREATE) !== true) {
                    throw new \RuntimeException('Cannot open ' . $destination);
                }

                $this->addContent($zip, $source);
                $zip->close();
            }
        }

        $url = basename($destination);
        return $url;
    }

    /**
     * This takes symlinks into account.
     *
     * @param ZipArchive $zip
     * @param string     $path
     */
    private function addContent(\ZipArchive $zip, string $path)
    {
        /** @var SplFileInfo[] $files */
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $path,
                \FilesystemIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        while ($iterator->valid()) {
            if (!$iterator->isDot()) {
                $filePath = $iterator->getPathName();
                $relativePath = substr($filePath, strlen($path) + 1);

                if (!$iterator->isDir()) {
                    $zip->addFile($filePath, $relativePath);
                } else {
                    if ($relativePath !== false) {
                        $zip->addEmptyDir($relativePath);
                    }
                }
            }
            $iterator->next();
        }
    }
}
